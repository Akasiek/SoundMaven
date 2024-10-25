import type Album from "~/interfaces/Album";
import type { RuntimeConfig } from "@nuxt/schema";

export default async function (slug: string | string[], config: RuntimeConfig): Promise<Album|null> {
  const { data } = await useFetch<{
    data: Album;
  }>(`${config.public.apiUrl}/albums/${slug}`);

  return data.value?.data || null;
}