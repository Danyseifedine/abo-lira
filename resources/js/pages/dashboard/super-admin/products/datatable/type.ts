export interface Product {
    id: number
    sku: string
    category_id: number
    quality_id: number
    name_en: string
    name_ar: string
    slug: string
    price: number | null
    stock_quantity: number | null
    has_variants: boolean
    is_new: boolean
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

