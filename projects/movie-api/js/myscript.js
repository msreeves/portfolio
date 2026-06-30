(() => {
  const queryInput = document.getElementById("theMovie");
  const searchButton = document.getElementById("searchButton");
  const statusMessage = document.getElementById("statusMessage");
  const prevPageButton = document.getElementById("prevPageButton");
  const nextPageButton = document.getElementById("nextPageButton");
  const pageInfo = document.getElementById("pageInfo");

  const titleEl = document.getElementById("title");
  const overviewEl = document.getElementById("overview");
  const releaseDateEl = document.getElementById("releaseDate");
  const ratingEl = document.getElementById("rating");
  const imageEl = document.getElementById("imageMovie");

  const appState = {
    query: "",
    page: 1,
    totalPages: 1,
    isLoading: false,
  };

  let debounceTimer = null;
  const placeholderPoster =
    "data:image/svg+xml;charset=UTF-8," +
    encodeURIComponent(
      '<svg xmlns="http://www.w3.org/2000/svg" width="250" height="375">' +
        '<rect width="100%" height="100%" fill="#1c1c1c"/>' +
        '<text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#f2f2f2" font-family="Arial" font-size="18">No Poster</text>' +
      "</svg>"
    );

  function setStatus(message, isError = false) {
    statusMessage.textContent = message;
    statusMessage.classList.toggle("status-error", isError);
  }

  function setLoading(isLoading) {
    appState.isLoading = isLoading;
    searchButton.disabled = isLoading;
    prevPageButton.disabled = isLoading || appState.page <= 1;
    nextPageButton.disabled = isLoading || appState.page >= appState.totalPages;
  }

  function updatePageInfo() {
    pageInfo.textContent = "Page " + appState.page + " of " + appState.totalPages;
    prevPageButton.disabled = appState.isLoading || appState.page <= 1;
    nextPageButton.disabled = appState.isLoading || appState.page >= appState.totalPages;
  }

  function renderMovie(movie) {
    titleEl.textContent = movie.title || "Not available";
    releaseDateEl.textContent = movie.releaseDate || "Not available";
    ratingEl.textContent =
      movie.rating === null || typeof movie.rating === "undefined"
        ? "Not available"
        : String(movie.rating);

    let overview = movie.overview || "No overview available.";
    if (Array.isArray(movie.genres) && movie.genres.length > 0) {
      overview += " Genres: " + movie.genres.join(", ") + ".";
    }
    if (movie.runtime && movie.runtime > 0) {
      overview += " Runtime: " + movie.runtime + " min.";
    }
    overviewEl.textContent = overview;

    if (movie.posterUrl) {
      imageEl.src = movie.posterUrl;
    } else {
      imageEl.src = placeholderPoster;
    }
  }

  async function fetchJson(url) {
    const response = await fetch(url, {
      headers: {
        Accept: "application/json",
      },
    });

    let payload = null;
    try {
      payload = await response.json();
    } catch (err) {
      payload = null;
    }

    if (!response.ok || !payload || payload.ok !== true) {
      const msg = payload && payload.error ? payload.error : "Request failed.";
      throw new Error(msg);
    }

    return payload;
  }

  async function enrichFirstMovie(movie) {
    if (!movie || !movie.id) {
      return movie;
    }
    try {
      const details = await fetchJson("./api/movie.php?id=" + encodeURIComponent(movie.id));
      if (details.movie) {
        return Object.assign({}, movie, details.movie);
      }
    } catch (err) {
      // Keep base search data if details lookup fails.
    }
    return movie;
  }

  async function runSearch(query, page = 1) {
    const cleanQuery = String(query || "").trim();
    if (!cleanQuery) {
      setStatus("Type a movie name to search.");
      return;
    }

    appState.query = cleanQuery;
    appState.page = page;
    setLoading(true);
    setStatus("Searching...");

    try {
      const data = await fetchJson(
        "./api/search.php?query=" +
          encodeURIComponent(cleanQuery) +
          "&page=" +
          encodeURIComponent(page)
      );

      appState.totalPages = Math.max(1, Number(data.totalPages || 1));
      updatePageInfo();

      if (!Array.isArray(data.results) || data.results.length === 0) {
        renderMovie({
          title: "No results found",
          releaseDate: "",
          rating: null,
          overview: "Try a different movie title.",
          posterUrl: "",
        });
        setStatus("No movies matched your search.");
        return;
      }

      const firstMovie = await enrichFirstMovie(data.results[0]);
      renderMovie(firstMovie);
      setStatus(
        "Showing top result for \"" +
          cleanQuery +
          "\" (" +
          String(data.totalResults || data.results.length) +
          " results)."
      );
    } catch (err) {
      const message = err instanceof Error ? err.message : "Search failed.";
      setStatus(message, true);
      renderMovie({
        title: "Unable to load movie",
        releaseDate: "",
        rating: null,
        overview: "Please try again in a moment.",
        posterUrl: "",
      });
    } finally {
      setLoading(false);
      updatePageInfo();
    }
  }

  queryInput.addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
      event.preventDefault();
      runSearch(queryInput.value, 1);
    }
  });

  queryInput.addEventListener("input", () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      if (queryInput.value.trim().length >= 2) {
        runSearch(queryInput.value, 1);
      }
    }, 350);
  });

  searchButton.addEventListener("click", () => {
    runSearch(queryInput.value, 1);
  });

  prevPageButton.addEventListener("click", () => {
    if (appState.page > 1 && !appState.isLoading) {
      runSearch(appState.query, appState.page - 1);
    }
  });

  nextPageButton.addEventListener("click", () => {
    if (appState.page < appState.totalPages && !appState.isLoading) {
      runSearch(appState.query, appState.page + 1);
    }
  });

  // Initial state
  renderMovie({
    title: "Ready to search",
    releaseDate: "",
    rating: null,
    overview: "Enter a movie title to load details from the API.",
    posterUrl: "",
  });
  setStatus("Type a movie title and press Search.");
  updatePageInfo();
})();
