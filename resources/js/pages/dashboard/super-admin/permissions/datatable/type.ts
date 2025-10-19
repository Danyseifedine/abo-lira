export interface Permission {
    id: number
    name: string
    guard_name: string
    created_at: string
    roles: Array<{ name: string; id: number }>
}

