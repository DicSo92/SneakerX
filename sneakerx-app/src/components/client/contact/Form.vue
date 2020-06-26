<template>
  <q-card class="my-card" square flat>
    <q-card-section class="no-padding q-mt-lg">
      <div class="text-h6">Contact Us</div>
      <div class="text-subtitle2">
        A question ? Contact us, we will be happy to answer you.
      </div>
    </q-card-section>

    <q-separator class="q-my-md"/>

    <q-card-section class="no-padding">
      <div class="column q-gutter-md">
        <div>
          <div class="q-col-gutter-md row items-start">
            <q-input v-model="firstname" label="Firstname" class="col" color="purple-10"
                     lazy-rules
                     :rules="[val => val !== null && val !== '' || 'Please type your firstname']"/>

            <q-input v-model="lastname" label="Lastname" class="col" color="purple-10"
                     lazy-rules
                     :rules="[val => val !== null && val !== '' || 'Please type your lastname']"/>
          </div>
        </div>


        <q-input autocomplete="email" color="purple-10"
                 v-model="email"
                 label="Your email *"
                 lazy-rules
                 :rules="[ val => val && val.length > 0 || 'Please type something']"/>

        <q-input v-model="mailObject" label="Object" color="purple-10"
                 lazy-rules
                 :rules="[val => val !== null && val !== '' || 'Please type something']"/>

        <q-input
          v-model="mailMessage"
          filled color="purple-10"
          type="textarea"
          lazy-rules
          :rules="[val => val !== null && val !== '' || 'Please type something']"
        />
      </div>

    </q-card-section>

    <q-separator class="q-my-md"/>

    <q-card-actions vertical class="no-padding">
      <q-btn color="purple-10" @click="sendMail" :disable="!validatedForm">Send Message</q-btn>
    </q-card-actions>
  </q-card>
</template>

<script>
    export default {
        name: "Form",
        data() {
            return {
                firstname: '',
                lastname: '',
                email: '',
                mailObject: '',
                mailMessage: ''
            }
        },
        computed: {
            validatedForm() {
                return this.firstname.length > 0 && this.lastname.length > 0 && this.email.length > 0 && this.mailObject.length > 0 && this.mailMessage.length > 0;
            },
        },
        methods: {
            sendMail () {
                this.$axios.post(`/api/client/contact`, {
                    firstname: this.firstname,
                    lastname: this.lastname,
                    email: this.email,
                    mailObject: this.mailObject,
                    mailMessage: this.mailMessage,
                })
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        }
    }
</script>

<style scoped>

</style>
