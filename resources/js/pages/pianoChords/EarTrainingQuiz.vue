<script setup lang="ts">
import { Volume2 } from "@lucide/vue";
import type { ChordDefinition } from "./types";

type QuizOption = { root: number; def: ChordDefinition };
type QuizAnswer = { option: QuizOption; correct: boolean } | null;

const props = defineProps<{
  score: number;
  total: number;
  current: QuizOption | null;
  options: QuizOption[];
  answered: QuizAnswer;
  noteName: (pitch: number) => string;
}>();

const emit = defineEmits<{
  replay: [];
  answer: [option: QuizOption];
  next: [];
}>();
</script>

<template>
  <section class="mx-auto w-full max-w-2xl rounded-2xl border border-[#dcd8ce] bg-[#fffdf8] p-6 text-center">
    <div class="flex justify-between border-b border-[#e9e5db] pb-4 text-xs"><span class="font-bold uppercase text-[#b56e4b]">Ear training quiz</span><span>Score: {{ score }} / {{ total }}</span></div>
    <h3 class="mt-6 text-2xl font-extrabold">Listen and identify the chord</h3>
    <button class="mx-auto my-5 flex items-center gap-2 rounded-2xl bg-[#e7b08c] px-6 py-3 font-bold text-[#173d3a]" @click="emit('replay')"><Volume2 class="h-5 w-5" />Replay chord</button>
    <div class="grid gap-3 sm:grid-cols-2">
      <button v-for="option in options" :key="`${option.root}-${option.def.id}`" :disabled="!!answered" class="rounded-xl border p-4" :class="answered && option.root === current?.root && option.def.id === current?.def.id ? 'bg-[#39766b] text-white' : answered?.option === option ? 'bg-[#b56e4b] text-white' : 'bg-[#f3f1eb]'" @click="emit('answer', option)">{{ noteName(option.root) }} {{ option.def.name }}</button>
    </div>
    <div v-if="answered" class="mt-5">
      <p :class="answered.correct ? 'text-[#39766b]' : 'text-[#b56e4b]'">{{ answered.correct ? "Correct!" : `It was ${noteName(current!.root)} ${current!.def.name}` }}</p>
      <button class="mt-3 rounded-xl bg-[#e7ded2] px-5 py-2 text-sm text-[#173d3a]" @click="emit('next')">Next question</button>
    </div>
  </section>
</template>
