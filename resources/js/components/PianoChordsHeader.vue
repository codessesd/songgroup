<script setup lang="ts">
  import { BookOpen, GraduationCap, Layers, ListMusic, Search, Volume2, VolumeX } from "@lucide/vue";

  type Tab = "explorer" | "identifier" | "scales" | "progressions" | "quiz";
  type SoundPreset = "piano" | "epiano" | "synth";

  defineProps<{
    activeTab: Tab;
    soundPreset: SoundPreset;
    muted: boolean;
  }>();

  const emit = defineEmits<{
    selectTab: [tab: Tab];
    "update:soundPreset": [preset: SoundPreset];
    "update:muted": [muted: boolean];
  }>();

  const tabs = [
    { id: "explorer", label: "Explorer", icon: BookOpen },
    { id: "identifier", label: "Finder", icon: Search },
    { id: "scales", label: "Scales", icon: Layers },
    { id: "progressions", label: "Progressions", icon: ListMusic },
    { id: "quiz", label: "Quiz", icon: GraduationCap },
  ] as const;

  const updateSoundPreset = (event: Event) => {
    emit("update:soundPreset", (event.target as HTMLSelectElement).value as SoundPreset);
  };
</script>

<template>
  <header class="border-b border-[#c9ddd5] bg-[#e4f0e9]">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-3 px-4 py-2 sm:px-6 lg:px-8">
      <nav class="flex max-w-full gap-1 overflow-x-auto rounded-xl border border-[#b8cec6] bg-[#d5e6df] p-1">
        <button
          v-for="item in tabs"
          :key="item.id"
          class="flex items-center gap-2 whitespace-nowrap rounded-lg px-3 py-2 text-sm"
          :class="
            activeTab === item.id
              ? 'bg-[#e7b08c] font-semibold text-[#173d3a]'
              : 'text-[#39766b] hover:bg-[#c6dcd4] hover:text-[#173d3a]'
          "
          @click="emit('selectTab', item.id)"
        >
          <component :is="item.icon" class="h-4 w-4" />{{ item.label }}
        </button>
      </nav>
      <div class="flex items-center gap-2">
        <select
          :value="soundPreset"
          class="rounded-lg border border-[#b8cec6] bg-[#d5e6df] px-2 py-2 text-xs text-[#173d3a]"
          @change="updateSoundPreset"
        >
          <option value="piano">Grand Piano</option>
          <option value="epiano">Electric Piano</option>
          <option value="synth">Warm Synth</option>
        </select>
        <button
          class="rounded-lg border border-[#b8cec6] bg-[#d5e6df] p-2"
          :aria-label="muted ? 'Unmute audio' : 'Mute audio'"
          @click="emit('update:muted', !muted)"
        >
          <VolumeX v-if="muted" class="h-4 w-4 text-[#b56e4b]" /><Volume2 v-else class="h-4 w-4 text-[#173d3a]" />
        </button>
      </div>
    </div>
  </header>
</template>
