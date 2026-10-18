import { z } from 'zod'

export const ProductRowSchema = z.object({
  id: z.string(),
  slug: z.string(),
  sku: z.string(),
  title: z.string(),
  category: z.string(),
  price: z.string(),
  image_url: z.string(),
  product_url: z.string().url(),
  inquiry_url: z.string().url(),
})

export const ProductCompanionFeedSchema = z.object({
  version: z.literal(1),
  programme: z.literal('msrproducts'),
  title: z.string(),
  mode: z.literal('catalog'),
  site_url: z.string().url(),
  shop_url: z.string().url(),
  contact_url: z.string().url(),
  disclaimer: z.string(),
  products: z.array(ProductRowSchema),
})

export type ProductRow = z.infer<typeof ProductRowSchema>
export type ProductCompanionFeed = z.infer<typeof ProductCompanionFeedSchema>
