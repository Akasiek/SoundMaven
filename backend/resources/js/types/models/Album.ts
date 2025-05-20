interface Album {
    id: string; // UUID
    title: string;
    slug: string;
    description: string;
    release_date: string;
    type: string;
    cover_image: string;
    average_rating: number;
    rating_color: string;

    created_at: string;
    updated_at: string;
    created_by: string;
    updated_by: string;
}

interface ExtendedAlbum extends Album {
    artist: Artist;
    tracks: Track[];
    genres: Genre[];
}
