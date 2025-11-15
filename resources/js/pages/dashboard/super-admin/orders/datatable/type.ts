export interface Order {
    id: number;
    order_number: string;
    f_name: string;
    l_name: string;
    phone_number: string;
    address: string;
    city: string;
    total_amount: string;
    status: 'pending' | 'accepted' | 'on_the_way' | 'completed' | 'rejected' | 'refunded';
    created_at: string;
}

