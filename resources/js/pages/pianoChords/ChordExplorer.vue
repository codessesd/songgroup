<script setup lang="ts">
import { Play } from "@lucide/vue";
import type { ChordDefinition } from "./types";

const props = defineProps<{
  rootNote: number;
  chordType: string;
  inversion: number;
  slashBass: number | null;
  noteName: (pitch: number) => string;
  currentChord: ChordDefinition;
  chordDefinitions: ChordDefinition[];
  calculatedNotes: number[];
}>();

const emit = defineEmits<{
  rootChange: [root: number];
  chordTypeChange: [chordType: string];
  inversionChange: [inversion: number];
  slashBassChange: [slashBass: number | null];
  play: [];
}>();

const categories = ["Triads", "7ths", "6ths", "Suspended", "Extended"];
</script>

<template>
  <section class="grid gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
      <div class="rounded-2xl border border-[#dcd8ce] bg-[#fffdf8] p-5">
        <label class="mb-3 block text-xs font-bold uppercase text-[#78817c]">Root pitch</label>
        <div class="grid grid-cols-6 gap-2 sm:grid-cols-12">
          <button
            v-for="(_, index) in 12"
            :key="index"
            class="rounded-xl border p-3 text-sm font-semibold"
            :class="rootNote === index ? 'border-[#e7b08c] bg-[#e7b08c] text-[#173d3a]' : 'border-[#dcd8ce] bg-[#f3f1eb]'"
            @click="emit('rootChange', index)"
          >
            {{ noteName(index) }}
          </button>
        </div>
      </div>
      <div class="rounded-2xl border border-[#dcd8ce] bg-[#fffdf8] p-5">
        <label class="mb-3 block text-xs font-bold uppercase text-[#78817c]">Chord quality</label>
        <div v-for="category in categories" :key="category" class="mb-4">
          <span class="mb-2 block text-[11px] uppercase text-[#a5aaa4]">{{ category }}</span>
          <div class="flex flex-wrap gap-2">
            <button
              v-for="def in chordDefinitions.filter((item) => item.category === category)"
              :key="def.id"
              class="rounded-xl border px-3 py-2 text-xs"
              :class="chordType === def.id ? 'border-[#e7b08c] bg-[#e7b08c] text-[#173d3a]' : 'border-[#dcd8ce] bg-[#f3f1eb]'"
              @click="emit('chordTypeChange', def.id)"
            >
              {{ noteName(rootNote) }}{{ def.abbr }} <span class="opacity-60">({{ def.name }})</span>
            </button>
          </div>
        </div>
      </div>
      <div class="grid gap-6 rounded-2xl border border-[#dcd8ce] bg-[#fffdf8] p-5 md:grid-cols-2">
        <div>
          <label class="mb-3 block text-xs font-bold uppercase text-[#78817c]">Inversion</label>
          <div class="grid grid-cols-2 gap-2">
            <button
              v-for="(label, index) in ['Root', '1st', '2nd', '3rd']"
              :key="label"
              class="rounded-lg border p-2 text-xs"
              :class="inversion === index ? 'border-[#e7b08c] bg-[#e7b08c] text-[#173d3a]' : 'border-[#dcd8ce] bg-[#f3f1eb]'"
              @click="emit('inversionChange', index)"
            >
              {{ label }}
            </button>
          </div>
        </div>
        <div>
          <label class="mb-3 block text-xs font-bold uppercase text-[#78817c]">Slash bass</label>
          <div class="flex flex-wrap gap-1">
            <button
              class="rounded border px-2 py-1 text-xs"
              :class="slashBass === null ? 'bg-[#39766b] text-white' : 'bg-[#f3f1eb]'"
              @click="emit('slashBassChange', null)"
            >
              None
            </button>
            <button
              v-for="(_, index) in 12"
              :key="index"
              class="rounded border bg-[#f3f1eb] px-2 py-1 text-xs"
              :class="slashBass === index ? 'bg-[#39766b] text-white' : ''"
              @click="emit('slashBassChange', index)"
            >
              /{{ noteName(index) }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="rounded-2xl border border-[#2d5c56] bg-[#173d3a] p-6 text-[#f7f3e9]">
      <div class="flex items-start justify-between">
        <div>
          <span class="text-xs uppercase tracking-widest text-[#e7b08c]">Active chord</span>
          <h3 class="mt-1 text-3xl font-extrabold">
            {{ noteName(rootNote) }}{{ currentChord.abbr }}<span v-if="slashBass !== null" class="text-[#a9c2ba]">/{{ noteName(slashBass) }}</span>
          </h3>
          <p class="text-sm text-[#a9c2ba]">{{ currentChord.name }}</p>
        </div>
        <button class="rounded-xl bg-[#e7b08c] p-3 text-[#173d3a]" title="Play chord" @click="emit('play')"><Play class="h-5 w-5 fill-current" /></button>
      </div>
      <div class="my-6 flex flex-wrap gap-2">
        <div v-for="(midi, index) in calculatedNotes" :key="`${midi}-${index}`" class="rounded-xl border border-[#47736b] bg-[#24504a] px-3 py-2 text-center">
          <strong>{{ noteName(midi) }}</strong><small class="block text-[#e7b08c]">{{ currentChord.intervals[index] || "Bass" }}</small>
        </div>
      </div>
      <div class="rounded-xl border border-[#47736b] bg-[#123330] p-3 text-sm text-[#e7b08c]">{{ currentChord.intervals.join(" - ") }}</div>
      <div class="mt-3 grid grid-cols-2 gap-2 text-xs">
        <div class="rounded-lg bg-[#24504a] p-2">Right hand<br /><strong>{{ currentChord.fingerings.RH }}</strong></div>
        <div class="rounded-lg bg-[#24504a] p-2">Left hand<br /><strong>{{ currentChord.fingerings.LH }}</strong></div>
      </div>
    </div>
  </section>
</template>
