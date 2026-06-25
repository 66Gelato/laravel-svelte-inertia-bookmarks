<script module lang="ts">
    export const layout = {
        breadcrumbs: [
            {
                title: 'Bookmarks',
                href: '/bookmarks',
            }
        ]
    }
</script>

<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    let { bookmarks } = $props();
</script>

<AppHead title="Bookmarks" />

<div class="flex h-full flex-1 flex-col gap-4 p-4">
  <h1 class="text-2xl font-bold">My Bookmarks</h1>

  <ul class="space-y-2">
    {#each bookmarks as bookmark (bookmark.id)}
      <li>
        <a href={bookmark.url} target="_blank" class="font-medium underline">
          {bookmark.title}
        </a>
        {#if bookmark.description}
          <span class="text-muted-foreground"> — {bookmark.description}</span>
        {/if}
      </li>
    {/each}
  </ul>
</div>