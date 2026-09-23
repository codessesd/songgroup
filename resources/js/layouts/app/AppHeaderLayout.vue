<script setup lang="ts">
import AppContent from '@/components/stock/AppContent.vue';
import AppHeader from '@/components/stock/AppHeader.vue';
import AppShell from '@/components/stock/AppShell.vue';
import { Toaster } from '@/components/stock/ui/sonner';
import type { BreadcrumbItem } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="header">
        <AppHeader :breadcrumbs="breadcrumbs" />
        <AppContent variant="header">
            <slot />
        </AppContent>
        <Toaster />
    </AppShell>
</template>
