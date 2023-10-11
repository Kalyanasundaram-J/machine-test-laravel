<script setup>
import TaskComponent from './TaskComponent.vue';
import { ref } from 'vue';

const taskId = ref(1);

function changeTask(id){
  taskId.value = id;
}
</script>

<template>
  <header class="mb-4">
    <div class="row mt-2 pt-2">
      <div class="col pe-0"><div class="border border-success rounded text-center p-2" :class="taskId==1?'bg-success':''" @click="changeTask(1)">Task 1</div></div>
      <div class="col px-0"><div class="border border-success rounded text-center p-2" :class="taskId==2?'bg-success':''" @click="changeTask(2)">Task 2</div></div>
      <div class="col ps-0"><div class="border border-success rounded text-center p-2" :class="taskId==3?'bg-success':''" @click="changeTask(3)">Task 3</div></div>
    </div>
  </header>

  <main>
    <TaskComponent :task-id="taskId"></TaskComponent>
  </main>
</template>