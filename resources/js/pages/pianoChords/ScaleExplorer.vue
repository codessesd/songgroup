<script setup lang="ts">
type Scale = { id: string; name: string; pattern: number[] };

const props = defineProps<{
  scaleRoot: number;
  selectedScale: string;
  currentScale: Scale;
  scales: Scale[];
  noteName: (pitch: number) => string;
}>();

const emit = defineEmits<{
  scaleRootChange: [root: number];
  scaleChange: [scale: string];
  exploreChord: [root: number, chordType: string];
}>();

const chordTypeForDegree = (index: number) => index === 0 || index === 3 || index === 4 ? "maj" : index === 6 ? "dim" : "m";
</script>

<template>
  <section class="grid gap-6 lg:grid-cols-3">
    <div class="space-y-6 rounded-2xl border border-[#dcd8ce] bg-[#fffdf8] p-6 lg:col-span-2">
      <div class="grid gap-5 md:grid-cols-2">
        <div>
          <label class="mb-2 block text-xs font-bold uppercase text-[#78817c]">Key root</label>
          <div class="grid grid-cols-6 gap-2">
            <button v-for="(_, index) in 12" :key="index" class="rounded-lg bg-[#f3f1eb] p-2 text-xs" :class="scaleRoot === index ? 'bg-[#e7b08c] text-[#173d3a]' : ''" @click="emit('scaleRootChange', index)">
              {{ noteName(index) }}
            </button>
          </div>
        </div>
        <div>
          <label class="mb-2 block text-xs font-bold uppercase text-[#78817c]">Scale type</label>
          <select :value="selectedScale" class="w-full rounded-xl border border-[#dcd8ce] bg-[#f3f1eb] p-3 text-sm" @change="emit('scaleChange', ($event.target as HTMLSelectElement).value)">
            <option v-for="scale in scales" :key="scale.id" :value="scale.id">{{ scale.name }}</option>
          </select>
        </div>
      </div>
      <div>
        <h3 class="mb-3 text-sm font-bold">Scale degrees</h3>
        <div class="flex flex-wrap gap-2">
          <div v-for="(offset, index) in currentScale.pattern" :key="offset" class="rounded-xl bg-[#f3f1eb] px-4 py-3 text-center">
            <small class="block text-[#b56e4b]">Degree {{ index + 1 }}</small><strong>{{ noteName(scaleRoot + offset) }}</strong>
          </div>
        </div>
      </div>
      <div>
        <h3 class="mb-3 text-sm font-bold">Diatonic chords</h3>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
          <button v-for="(offset, index) in currentScale.pattern" :key="offset" class="rounded-xl border border-[#dcd8ce] bg-[#f3f1eb] p-3 text-left" @click="emit('exploreChord', (scaleRoot + offset) % 12, chordTypeForDegree(index))">
            <small class="block text-[#b56e4b]">Step {{ index + 1 }}</small><strong>{{ noteName(scaleRoot + offset) }}</strong>
          </button>
        </div>
      </div>
    </div>
    <div class="rounded-2xl border border-[#dcd8ce] bg-[#fffdf8] p-6 text-sm text-[#78817c]">
      <h4 class="mb-3 font-semibold text-[#17211f]">Scale harmonization</h4>
      <p>Explore the natural chord qualities inside each scale and use them as a starting point for writing.</p>
    </div>
  </section>
</template>
