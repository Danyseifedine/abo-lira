export interface Role {
    id: number
    name: string
    guard_name: string
    created_at: string
    permissions: Array<{ name: string; id: number }>
    permissions_count?: number
}

