<template>
    <section class="form-02-main">
        <div class="container m-auto mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="_lk_de">
                        <form @submit.prevent="submitForm" class="form-03-main">
                            <div class="logo">
                                <img src="../../admin/images/user.png">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control _ge_de_ol"  placeholder="Enter Email" required="" aria-required="true" v-model="form.email">
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control _ge_de_ol"  placeholder="Enter Password" required="" aria-required="true" v-model="form.password">
                            </div>

                            <div class="checkbox form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="">
                                    <label class="form-check-label" for="">
                                        Remember me
                                    </label>
                                </div>
                                <a href="#">Forgot Password</a>
                            </div>

                            <div class="form-group">
                                <div class="_btn_04">
                                    <button type="submit">Login</button>
                                </div>
                            </div>

                            <div class="nm_lk"><p>Or Login With</p></div>

                            <div class="form-group pt-0">
                                <div class="_social_04">
                                    <ol>
                                        <li><i class="mdi mdi-facebook"></i></li>
                                        <li><i class="mdi mdi-twitter"></i></li>
                                        <li><i class="mdi mdi-google"></i></li>
                                        <li><i class="mdi mdi-instagram"></i></li>
                                        <li><i class="mdi mdi-linkedin"></i></li>
                                    </ol>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';


export default {
  name: 'Login',
  setup() {
    const form = ref({
      email: '',
      password: '',
    });

    const router = useRouter();

    onMounted(() => {
      const token = localStorage.getItem('token');
      if (token) {
        // User already has a token, redirect to the home page or desired authenticated route
        router.push({ path: '/' });

      }
    });

    const submitForm = async (e) => {
      e.preventDefault();

        try {
            const response = await axios.post('/api/auth/login', form.value);
            const token = response.data.access_token;
            const userRole = response.data.user.role;

            localStorage.setItem('token', token);
            localStorage.setItem('userRole', userRole); // Store the user role in local storage


            if (userRole === 'admin') {
                // Redirect the admin user to the admin dashboard
                router.push({ path: '/admin' });
            } else {
                // Redirect non-admin users to the home page or desired authenticated route
                router.push({ path: '/' });
            }

        } catch (error) {
            console.error(error);
        }
    };

    return {
      form,
      submitForm,
    };
  },
};
</script>

<style scoped>
* {
    margin: 0;
    padding: 0;
    list-style: none;
}

body{
    font-family: "Open Sans",serif;
}

img {
    max-width: 100%;
}

a {
    text-decoration: none;
    outline: none;
    color: #444;
}



a:hover {
    color: #444;
}

ul {
    margin-bottom: 0;
    padding-left: 0;
}

ol,ul{
    margin:0px;
    padding:0px;
}

a:hover,
a:focus,
input,
textarea {
    text-decoration: none;
    outline: none;
}

.form-02-main{
    background:url(../../admin/images/bg-01.jpg);
    background-size:cover;
    height: 100vh;
    background-repeat:no-repeat;
    background-position:center;
    position:relative;
    z-index:2;
    overflow:hidden;
}

._lk_de{

    background-repeat:no-repeat;
    background-size:cover;
    padding:40px 0px;
    position:relative;

}

.form-03-main{
    width:500px;
    display:block;
    margin:20px auto;
    padding:25px 50px 25px;
    background:rgba(255,255,255,0.6);
    border-radius:6px;
    z-index:9;
}

.logo{
    display:block;
    margin:20px auto;
    width:100px;
    height:100px;
}

.form-group{
    padding:20px 0px;
    display:inline-block;
    width:100%;
    position:relative;
}

.form-group p{
    margin:0px;
}

.form-control{
    min-height:45px;
    -webkit-box-shadow: none;
    box-shadow: none;
    padding: 10px 15px;
    border-radius:20px;
    border:1px solid#2b3990;
}

.checkbox{
    display:flex;
    justify-content:space-around;
}

button {
    display: inline-block;
    width: 100%;
    padding: 12px 0px;
    background: #2b3990;
    border-radius: 20px;
    text-align: center;
    font-size: 16px;
    color: #fff;
}

._btn_04 a{
    font-size:15px;
    color:#fff;
}

._social_04{
    display:block;
    width:100%;
    padding:15px 0px;
    text-align:center;
}

._social_04 ol li{
    display:inline-block;
    width:40px;
    height:40px;
    text-align:center;
    line-height:40px;
    transition:0.2s;
    background:#fff;
    border-radius:50px;
    border:1px solid#2b3990;
    margin:0 0 0 10px;
    transition:0.2s;
}

._social_04 ol li:nth-child(1):hover{
    background:#3b5998;
    border:1px solid#3b5998;
    color:#fff;
    transition:0.2s;
}

._social_04 ol li:nth-child(2):hover{
    background:#00aced;
    border:1px solid#00aced;
    color:#fff;
    transition:0.2s;
}

._social_04 ol li:nth-child(3):hover{
    background:#c32f10;
    border:1px solid#c32f10;
    color:#fff;
    transition:0.2s;
}

._social_04 ol li:nth-child(4):hover{
    background:#E1306C;
    border:1px solid#E1306C;
    color:#fff;
    transition:0.2s;
}

._social_04 ol li:nth-child(5):hover{
    background:#0177b5;
    border:1px solid#0177b5;
    color:#fff;
    transition:0.2s;
}

._social_04 ol li:hover,._social_04 ol li:hover i{
    color:#fff;
}

._social_04 ol li i:nth-child(1):hover{
    color:#fff;
}

._social_04 ol li i{
    font-size:15px;
    color:#2b3990;
}

.nm_lk{
    text-align:center;
}

@media screen and (max-width: 600px) {
    .form-03-main{
        width: 100%;
    }
}

@media screen and (max-width: 900px){
    .form-02-main {
        overflow: auto;
    }
}
</style>
