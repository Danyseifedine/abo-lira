export interface OrderItem {
    id: number;
    order_id: number;
    product_id: number;
    variant_id: number;
    quantity: number;
    price: string;
    product?: {
        id: number;
        name: string;
        name_en: string;
        name_ar: string;
        image: string;
        sku: string;
    };
    variant?: {
        id: number;
        sku: string;
        image: string;
        price: string;
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
    };
}

export interface OrderHistory {
    id: number;
    order_id: number;
    status: string;
    status_raw: string;
    created_at: string;
}

export interface Order {
    id: number;
    order_number: string;
    f_name: string;
    l_name: string;
    phone_number: string;
    address: string;
    city: string;
    total_amount: string;
    status: string;
    status_raw: 'pending' | 'accepted' | 'on_the_way' | 'completed' | 'rejected' | 'refunded';
    created_at: string;
    items?: OrderItem[];
    histories?: OrderHistory[];
}

