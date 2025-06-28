import { ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { SharedData, User } from "@/types";

export function useAuthUser() {
  const page = usePage<SharedData>();
  const user = ref<User | null>(page.props?.auth?.user ?? null);

  watch(() => page.props?.auth?.user, (newUser) => {
    user.value = newUser ?? null;
  });

  return user;
}
