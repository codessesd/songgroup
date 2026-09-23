<script setup lang="ts">
import AppContent from '@/components/stock/AppContent.vue';
import AppShell from '@/components/stock/AppShell.vue';
import AppSidebar from '@/components/stock/AppSidebar.vue';
import AppSidebarHeader from '@/components/stock/AppSidebarHeader.vue';
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
    <AppShell variant="sidebar">
        <AppSidebar />
        <AppContent variant="sidebar" class="min-w-0 overflow-x-clip">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </AppContent>
        <Toaster />
    </AppShell>
</template>
