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

export interface Category {
  data: {
    [key: string]: CategoryData
  }
  meta: {
    links: PaginationLinks[]
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

export interface Post {
  data: {
    [key: string]: PostData
  }
  links: Array<any>
}

export interface Tag {
  data: {
    [key: string]: TagData
  }
  meta: {
    links: PaginationLinks[]
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

export interface CategoryData {
  id: number
  name: string
  slug: string
  description: string
  posts_count: number
}

export interface CommentData {
  id: number
  author: string
  content: string
  post: string
  submitted_at: string
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

export interface TagData {
  id: number
  name: string
  slug: string
  description: string
  posts_count: number
}

export interface UserData {
  id: number
  name: string
  email: string
  role: string
  posts_count: number
}

export interface SingleCategory {
  data: {
    id: number
    name: string
    slug: string
    description: string
  }
}

export interface SingleComment {
  data: {
    id: number
    author: string
    content: string
    post: string
    submitted_at: string
  }
}

export interface SingleTag {
  data: {
    id: number
    name: string
    slug: string
    description: string
  }
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

export interface PaginationLinks {
  active: boolean
  label: string
  url: string
}

export interface Filters {
  search?: string
}

export interface GlanceData {
  posts: number
  pages: number
  comments: number
  spam: number
}

export interface Settings {
  key: string
  value: string
}

export interface Timezone {
  group: string
  data: {
    name: string
    value: string
    selected: boolean
  }[]
}

export interface TimeFormat {
  [key: string]: {
    label: string
    value: string
  }
}

export interface DateFormat {
  [key: string]: {
    label: string
    value: string
  }
}
