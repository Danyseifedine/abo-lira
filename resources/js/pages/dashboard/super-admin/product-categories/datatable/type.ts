export interface ProductCategory {
    id: number
    parent_id: number | null
    name_en: string
    name_ar: string
    slug: string
    status: boolean
    created_at: string
    parent?: {
        id: number
        name_en: string
        name_ar: string
    }
}

