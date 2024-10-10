<script lang="ts" setup>
import { useAuthStore } from "~/store/auth";

const { login } = useAuthStore();
const router = useRouter();

const user = ref({
  email: '',
  password: '',
});

const handleLogin = async () => {
  await login(user.value);

  // Redirect to home page
  await router.push('/');
};

</script>

<template>
  <div>
    <div class="title">
      <h2>Login</h2>
    </div>
    <div class="container form">
      <label for="uname"><b>E-mail</b></label>
      <input
          v-model="user.email"
          type="text"
          class="input"
          placeholder="Enter Email"
          name="email"
          required
      >

      <label for="psw"><b>Password</b></label>
      <input
          v-model="user.password"
          type="password"
          class="input"
          placeholder="Enter Password"
          name="psw"
          required
      >

      <button class="button" @click.prevent="handleLogin">Login</button>
    </div>
  </div>
</template>
