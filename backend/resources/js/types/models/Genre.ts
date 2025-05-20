interface Genre {
    id: string; // UUID
    name: string;
    slug: string;
    description: string;

    created_at: string;
    updated_at: string;
    created_by: string;
    updated_by: string;
}

interface ExtendedGenre extends Genre {
    albums: Album[];
}
