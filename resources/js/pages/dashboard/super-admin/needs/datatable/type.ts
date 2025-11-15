export interface Need {
    id: number;
    f_name: string;
    l_name: string;
    phone_number: string;
    message: string;
    status: 'unread' | 'read';
    created_at: string;
    updated_at: string;
    image?: string;
}

