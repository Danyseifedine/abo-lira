export interface User {
    id: number
    name: string
    email: string
    email_verified_at: string | null
    created_at: string
    roles: Array<{ name: string; id: number }>
    permissions: Array<{ name: string; id: number }>
    is_active?: boolean
    avatar_url?: string | null
}
