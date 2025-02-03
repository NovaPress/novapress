export interface User {
  id: number
  name: string
  email: string
  email_verified_at?: string
}

export type PageProps<
  T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
  auth: {
    user: User
  }
}

export interface Post {
  data: {
    [key: string]: PostData
  }
  links: Array<any>
}

export interface PostData {
  id: number
  title: string
  author: string
  slug: string
  body: string
  published_at: string
}

export interface Filters {
  search?: string
}
