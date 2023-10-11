<script setup>
import { reactive, ref, watch } from 'vue';
import axios from 'axios';
const props = defineProps({
    taskId: {
        type: Number,
        required: true
    }
})
watch(()=>props.taskId,()=>{
    result.value = "";
    alertObject.active = false;
});
const alertObject = reactive({
    active:false,
    message:""
});
const loading = ref(false);
const task1 = reactive({
    limit1: "",
    limit2:""
});
const task2 = reactive({
    string:""
});
const task3 = reactive({
    number:""
});
const result = ref("");
async function onSubmitClick() {
    loading.value = true;
    alertObject.active = false;
    if(props.taskId==1){
        if (!/^\d+$/.test(task1.limit1) || !/^\d+$/.test(task1.limit2)) {
            alertMessage('Please enter valid integer in both limit1 and limit2')
            loading.value = false;
            return;
        }
        await axios.get(`http://localhost:8080/api/task1?limit1=${task1.limit1}&limit2=${task1.limit2}`)
        .then(response => {
          const responseData = response.data.data;
          result.value = responseData;
          loading.value = false;
        })
        .catch(error => {
          alertMessage(error.response.data.message?error.response.data.message:"Try again later");
          loading.value = false;
        });
    }
    else if(props.taskId==2){
        if(!task2.string){
            alertMessage("Please enter the string.");
            loading.value = false;
            return;
        }
        await axios.post('http://localhost:8080/api/task2',{'longstring':task2.string})
        .then(response => {
          const responseData = response.data.data;
          result.value = [responseData];
          loading.value = false;
        })
        .catch(error => {
            alertMessage(response.data.message?response.data.message:"Try again later");
            loading.value = false;
        });
    }
    else if(props.taskId==3){
        if (!/^\d{3}$/.test(task3.number)) {
            alertMessage('Please enter a 3-digit number.');
            loading.value = false;
            return;
        }
        await axios.get(`http://localhost:8080/api/task3?number=${task3.number}`)
        .then(response => {
          const responseData = response.data.data;
          result.value = [responseData];
          loading.value = false;
        })
        .catch(error => {
            alertMessage(response.data.message?response.data.message:"Try again later");
            loading.value = false;
        });
    }
    else{
        loading.value = false;
    }
}

function alertMessage(message){
    alertObject.active = true;
    alertObject.message = message;
    setTimeout(()=>{
        alertObject.active = false;
        alertObject.message = "";
    },5000);
}
</script>

<template>
    <div>
        <div v-if="taskId==1" class="m-2">
            <div class="row">
                <hr class="text-primary">
                <h6 class="col text-center">
                    List of number that remains the same when its digits are reversed in a given limit.
                </h6>
                <hr class="text-primary">
            </div>
            <div class="row">
                <div class="col-12 py-3">
                    <span class="text-danger">Fields marked with an asterisk (*) are required.</span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-group mb-3 border border-secondary-subtle rounded">
                        <span class="input-group-text" id="limit1">Limit 1 <span class="text-danger">*</span></span>
                        <input type="number" class="form-control rounded" placeholder="Lower Limit" aria-label="Lower Limit" aria-describedby="limit1" v-model="task1.limit1">
                        <button class="input-group-text" @click="task1.limit1=''"><strong>X</strong></button>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group mb-3 border border-secondary-subtle rounded">
                        <span class="input-group-text" id="limit2">Limit 2<span class="text-danger">*</span></span>
                        <input type="number" class="form-control rounded" placeholder="Upper Limit" aria-label="Upper Limit" aria-describedby="limit2" v-model="task1.limit2">
                        <button class="input-group-text" @click="task1.limit2=''"><strong>X</strong></button>
                    </div>
                </div>
            </div>
        </div>
        <div v-else-if="taskId==2" class="m-2">
            <div class="row">
                <hr class="text-primary">
                <h6 class="col text-center">
                    Reverse words and characters in a given string.
                </h6>
                <hr class="text-primary">
            </div>
            <div class="row">
                <div class="col-12 py-3">
                    <span class="text-danger">Fields marked with an asterisk (*) are required.</span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-group mb-3 border border-secondary-subtle rounded">
                        <span class="input-group-text" id="stringInput">String <span class="text-danger">*</span></span>
                        <input type="text" class="form-control rounded" aria-label="String Input" aria-describedby="stringInput" required placeholder="Enter the String" v-model="task2.string">
                        <button class="input-group-text" @click="task2.string=''"><strong>X</strong></button>
                    </div>
                </div>
            </div>
        </div>
        <div v-else-if="taskId==3" class="m-2">
            <div class="row">
                <hr class="text-primary">
                <h6 class="col text-center">
                    Find number of possible unique combinations for a 3 digit number
                </h6>
                <hr class="text-primary">
            </div>
            <div class="row">
                <div class="col-12 py-3">
                    <span class="text-danger">Fields marked with an asterisk (*) are required.</span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-group mb-3 border border-secondary-subtle rounded">
                        <span class="input-group-text" id="threeDigit">3-digit Number <span class="text-danger">*</span></span>
                        <input type="number" maxlength="3" class="form-control rounded" aria-label="3 digit number" aria-describedby="threeDigit" required placeholder="Enter a 3-digit number" v-model="task3.number">
                        <button class="input-group-text" @click="task3.number=''"><strong>X</strong></button>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <h5 class="text-center m-4"><strong>Task {{ taskId }}</strong> <small>is not active.</small></h5>
        </div>
        <div v-if="taskId == 1 || taskId ==2 || taskId == 3" id="footer" class="mt-3">
            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-primary btn-sm rounded" :disabled="loading" @click="onSubmitClick()">
                        <div v-if="loading" class="spinner-grow spinner-grow-sm"  role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span v-else>Submit</span>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <hr class="text-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="ms-2"><u>Result</u></h5>
                </div>
                <div class="col-12">
                    <div class="row mx-2 my-3 p-2 border border-primary rounded">
                        <div v-for="val,index in result" class="col-auto border border-primary-subtle me-1 mb-1 rounded px-2" :key="index">
                            {{ val }}
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="alertObject.active" class="alert alert-danger" role="alert">
                {{ alertObject.message }}
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>