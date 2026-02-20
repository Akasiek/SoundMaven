interface PaginatedData<T> {
    data: T[];
    links: PaginatedDataLinks;
    meta: PaginatedDataMeta;
}

interface PaginatedDataLinks {
  first: string | null;
  last: string | null;
  prev: string | null;
  next: string | null;
}

interface PaginatedDataMeta {
  current_page: number;
  from: number | null;
  last_page: number;
  links: Array<{
    url: string |null;
    label: string|null;
    page: number | null;
    active: boolean;
  }>;
  path: string;
  per_page: number;
  to: number | null;
  total: number;
}
