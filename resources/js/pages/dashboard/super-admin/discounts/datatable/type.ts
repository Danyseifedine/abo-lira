export interface DiscountProduct {
    id: number;
    sku: string;
    name_en: string;
    name_ar: string;
    name: string;
    discount_price: string;
    discount_start_date: string | null;
    discount_end_date: string | null;
    has_limited_time_discount: boolean;
    is_discounted: boolean;
    created_at: string;
    image?: string;
    category?: {
        id: number;
        name_en: string;
        name_ar: string;
    };
    quality?: {
        id: number;
        name_en: string;
        name_ar: string;
    };
    variants?: Array<{
        id: number;
        sku: string;
        price: string;
        image?: string;
        color?: {
            id: number;
            name_en: string;
            name_ar: string;
            hex: string;
        };
        size?: {
            id: number;
            name_en: string;
            name_ar: string;
        };
    }>;
}

