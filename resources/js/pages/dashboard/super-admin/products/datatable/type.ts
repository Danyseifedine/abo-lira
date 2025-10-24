export interface Product {
    id: number
    sku: string
    category_id: number
    quality_id: number
    name_en: string
    name_ar: string
    slug: string
    description_en?: string | null
    description_ar?: string | null
    price: number | null
    stock_quantity: number | null
    out_of_stock: boolean
    has_variants: boolean
    is_new: boolean
    featured: boolean
    status: boolean
    created_at: string
    category?: {
        id: number
        name_en: string
        name_ar: string
    }
    quality?: {
        id: number
        name_en: string
        name_ar: string
    }
}

