<script setup lang="ts">
import { Play } from "@lucide/vue";
import type { ChordDefinition } from "./types";

type Progression = { name: string; chords: { r: number; t: string }[] };

const props = defineProps<{
  progressions: Progression[];
  selectedProgression: Progression;
  chordDefinitions: ChordDefinition[];
  progressionStep: number;
  playing: boolean;
  tempo: number;
  noteName: (pitch: number) => string;
}>();

const emit = defineEmits<{
  select: [progression: Progression];
  toggle: [];
  tempoChange: [tempo: number];
}>();

const abbreviation = (type: string) => props.chordDefinitions.find((definition) => definition.id === type)?.abbr ?? "";
</script>

<template>
  <section class="grid gap-6 lg:grid-cols-3">
    <div class="space-y-6 rounded-2xl border border-slate-800 bg-slate-900 p-6 lg:col-span-2">
      <div class="flex items-center justify-between">
        <div><h3 class="text-lg font-bold">Popular progressions</h3><p class="text-xs text-slate-400">Select a progression and play it back.</p></div>
        <button class="flex items-center gap-2 rounded-xl px-4 py-2 font-bold" :class="playing ? 'bg-rose-600' : 'bg-emerald-600'" @click="emit('toggle')"><Play class="h-4 w-4 fill-current" />{{ playing ? "Stop" : "Play" }}</button>
      </div>
      <div class="grid gap-3 sm:grid-cols-2">
        <button v-for="progression in progressions" :key="progression.name" class="rounded-xl border p-4 text-left" :class="selectedProgression.name === progression.name ? 'border-indigo-500 bg-indigo-950/50' : 'border-slate-800 bg-slate-950'" @click="emit('select', progression)">
          <strong class="block text-sm">{{ progression.name }}</strong><span class="text-xs text-indigo-300">{{ progression.chords.map((chord) => noteName(chord.r) + abbreviation(chord.t)).join(" · ") }}</span>
        </button>
      </div>
      <div class="grid grid-cols-4 gap-3 rounded-xl border border-slate-800 bg-slate-950 p-5">
        <div v-for="(chord, index) in selectedProgression.chords" :key="index" class="rounded-xl p-3 text-center" :class="playing && progressionStep === index ? 'bg-indigo-600' : 'bg-slate-900'"><small class="block text-slate-400">Chord {{ index + 1 }}</small><strong>{{ noteName(chord.r) }}{{ abbreviation(chord.t) }}</strong></div>
      </div>
    </div>
    <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
      <h4 class="mb-4 font-semibold">Tempo: {{ tempo }} BPM</h4>
      <input :value="tempo" type="range" min="60" max="180" class="w-full accent-indigo-500" @input="emit('tempoChange', Number(($event.target as HTMLInputElement).value))" />
    </div>
  </section>
</template>
