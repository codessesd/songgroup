<script setup lang="ts">
  import { computed } from "vue";

  const BLACK_KEYS = [1, 3, 6, 8, 10];
  const START_MIDI = 36;
  const TOTAL_KEYS = 36;

  const props = defineProps<{
    activeNotes: number[];
    rootNoteMidi: number | null;
    noteName: (pitch: number) => string;
    intervalTag: (midi: number) => string;
    accidentalMode: "sharps" | "flats" | "custom";
    setMode: boolean;
  }>();

  const emit = defineEmits<{
    keyClick: [midi: number];
    toggleAccidental: [midi: number];
  }>();

  const whiteKeys = computed(() =>
    Array.from({ length: TOTAL_KEYS }, (_, index) => START_MIDI + index).filter((midi) => !BLACK_KEYS.includes(midi % 12)),
  );
  const blackKeys = computed(() =>
    Array.from({ length: TOTAL_KEYS }, (_, index) => START_MIDI + index).filter((midi) => BLACK_KEYS.includes(midi % 12)),
  );
  const whiteIndex = (midi: number) => whiteKeys.value.indexOf(midi);
  const blackLeft = (midi: number) => whiteKeys.value.filter((key) => key < midi).length - 1;
  const isRoot = (midi: number) => props.rootNoteMidi !== null && midi % 12 === props.rootNoteMidi % 12;
  const canSetAccidental = computed(() => props.accidentalMode === "custom" && props.setMode);
</script>

<template>
  <div class="overflow-x-auto pb-2">
    <svg :width="whiteKeys.length * 36" height="180" class="min-w-[720px] select-none">
      <g v-for="midi in whiteKeys" :key="midi" class="cursor-pointer" @click="emit('keyClick', midi)">
        <rect
          :x="whiteIndex(midi) * 36"
          width="34.5"
          height="180"
          rx="4"
          :class="
            activeNotes.includes(midi)
              ? isRoot(midi)
                ? 'fill-[#39766b] stroke-[#a9c2ba]'
                : 'fill-[#b56e4b] stroke-[#f1c09f]'
              : 'fill-[#fffdf8] stroke-[#dcd8ce]'
          "
        />
        <text
          :x="whiteIndex(midi) * 36 + 18"
          y="168"
          text-anchor="middle"
          :class="activeNotes.includes(midi) ? 'fill-white font-bold' : 'fill-[#53645f] text-xs'"
        >
          {{ noteName(midi) }}
        </text>
        <text
          v-if="activeNotes.includes(midi) && intervalTag(midi)"
          :x="whiteIndex(midi) * 36 + 18"
          y="148"
          text-anchor="middle"
          class="fill-white text-xs font-bold"
        >
          {{ intervalTag(midi) }}
        </text>
      </g>
      <g
        v-for="midi in blackKeys"
        :key="midi"
        class="cursor-pointer"
        @click="emit('keyClick', midi)"
        @pointerdown="canSetAccidental ? emit('toggleAccidental', midi) : undefined"
      >
        <rect
          :x="(blackLeft(midi) + 1) * 36 - 11"
          width="22"
          height="110"
          rx="3"
          :class="
            activeNotes.includes(midi)
              ? isRoot(midi)
                ? 'fill-[#b56e4b] stroke-[#f1c09f]'
                : 'fill-[#b56e4b] stroke-[#f1c09f]'
              : canSetAccidental
                ? 'fill-[#173d3a] stroke-[#e7b08c]'
                : 'fill-[#173d3a] stroke-[#47736b]'
          "
        />
        <text :x="(blackLeft(midi) + 1) * 36" y="102" text-anchor="middle" class="fill-[#c6d5ce] text-[9px] font-bold">
          {{ noteName(midi) }}
        </text>
      </g>
    </svg>
  </div>
</template>
