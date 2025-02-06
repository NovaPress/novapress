export interface AuthUser {
  id: number
  name: string
  email: string
  email_verified_at?: string
}

export type PageProps<
  T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
  auth: {
    user: AuthUser
  }
}

export interface User {
  data: {
    [key: string]: UserData
  }
  meta: {
    links: PaginationLinks[]
  }
}

export interface UserData {
  id: number
  name: string
  email: string
  role: string
  posts_count: number
}

export interface SingleUser {
  data: {
    id: number
    name: string
    email: string
    role: string
    posts_count: number
  }
}

export interface Comment {
  data: {
    [key: string]: CommentData
  }
  meta: {
    links: PaginationLinks[]
  }
}

export interface CommentData {
  id: number
  author: string
  content: string
  post: string
  submitted_at: string
}

export interface PaginationLinks {
  active: boolean
  label: string
  url: string
}

export interface Post {
  data: {
    [key: string]: PostData
  }
  links: Array<any>
}

export interface Category {
  data: {
    [key: string]: CategoryData
  }
  links: Array<any>
}

export interface Tag {
  data: {
    [key: string]: TagData
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
  categories: Array<string>
}

export interface Filters {
  search?: string
}

export interface CategoryData {
  id: number
  name: string
  slug: string
  description: string
  posts_count: number
}

export interface TagData {
  id: number
  name: string
  slug: string
  description: string
  posts_count: number
}

export interface SingleCategory {
  id: number
  name: string
  slug: string
  description: string
}

export interface SingleTag {
  id: number
  name: string
  slug: string
  description: string
}
