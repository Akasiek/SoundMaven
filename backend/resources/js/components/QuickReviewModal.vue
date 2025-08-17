<script setup lang="ts">
import { ref, watch } from "vue";
import { MessageCirclePlus, X } from "lucide-vue-next";
import InputError from "@/components/inputs/InputError.vue";
import { Label } from "@/components/shadcn/ui/label";
import { Input } from "@/components/shadcn/ui/input";
import { useForm } from "@inertiajs/vue3";
import debounce from "lodash.debounce";
import axios from "axios";

const showModal = ref(false);
const queryResults = ref<{ data: {albums: ExtendedAlbum[] } } | null>(null);
const form = useForm<{ query: string; }>({ query: '' });

const submit = debounce(() => {
  axios.get(route('search', { 'type': 'album', 'query': form.query }))
    .then(response => {
      queryResults.value = response.data;
    })
    .catch(() => {
      queryResults.value = null;
      form.errors.query = 'An error occurred while searching for albums.';
    });
}, 300)

watch(form, () => {
  submit()
});

</script>

<template>
  <button
    @click="showModal = !showModal"
    class="
      fixed bottom-12 right-16 w-14 h-14 p-2.5 bg-green-500 z-50 flex items-center justify-center rounded-full shadow-[0_0_0] hover:shadow-[0_0_1rem]
      transition-all duration-300 ease-in-out shadow-green-500/75 cursor-pointer
    ">
    <MessageCirclePlus class="h-full w-full"/>
  </button>
  <Transition
    enter-active-class="data-[state=open]:animate-in data-[state=open]:fade-in-0 duration-200"
    leave-active-class="data-[state=closed]:animate-out data-[state=closed]:fade-out-0 duration-200"
    enter-from-class="data-[state=closed]:fade-out-0"
    enter-to-class="data-[state=open]:fade-in-0"
    leave-from-class="data-[state=open]:fade-in-0"
    leave-to-class="data-[state=closed]:fade-out-0"
  >
    <div
      v-show="showModal"
      :data-state="showModal ? 'open' : 'closed'"
      class="fixed inset-0 z-50 bg-black/80 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 duration-200 flex items-center justify-center"
      @click.self="showModal = false"
    >
      <Transition
        enter-active-class="data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95 duration-200"
        leave-active-class="data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95 duration-200"
        enter-from-class="data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95"
        enter-to-class="data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95"
        leave-from-class="data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95"
        leave-to-class="data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95"
      >
        <div
          v-show="showModal"
          :data-state="showModal ? 'open' : 'closed'"
          @click.stop
          class="relative min-h-36 max-h-[90dvh] min-w-96 overflow-y-auto bg-zinc-850 rounded-lg shadow-lg border-2 border-zinc-800 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 duration-200"
        >

          <button class="absolute top-4 right-4 text-white text-2xl z-50 cursor-pointer" @click="showModal = false">
            <X :size="24"/>
          </button>

          <form @submit.prevent="submit" class="px-8 py-12">
            <div class="grid gap-2">
              <Label for="query">Search Album</Label>
              <Input
                id="query"
                type="text"
                v-model="form.query"
                required
              />
              <InputError :message="form.errors.query"/>
            </div>
          </form>


        </div>
      </Transition>
    </div>
  </Transition>
</template>
