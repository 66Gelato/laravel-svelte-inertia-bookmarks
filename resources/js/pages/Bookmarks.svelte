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
    import { Form } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import InputError from '@/components/InputError.svelte';
    import { Button } from '@/components/ui/button';
    import { Input } from '@/components/ui/input';
    import { Label } from '@/components/ui/label';
    import { store } from '@/routes/bookmarks';
    
    // from BookmarkController
    let { bookmarks } = $props();

    let search = $state('');
    let selectedTag = $state<string | null>(null);

    // every unique tag name across all bookmarks , for the filter buttons 
    let allTags = $derived.by(() => {
        const names = new Set<string>();
        for (const b of bookmarks) {
          for (const t of b.tags) names.add(t.name);
        }
        return [...names].sort();
    });

    let filtered = $derived.by(() => {
      const term = search.trim().toLowerCase();
      return bookmarks.filter((b) => {
        const matchesSearch =
          term === '' ||
          b.title.toLowerCase().includes(term) ||
          b.url.toLowerCase().includes(term) ||
          (b.description?.toLowerCase().includes(term) ?? false);

        const matchesTag =
          selectedTag === null || b.tags.some((t) => t.name === selectedTag);

        return matchesSearch && matchesTag;
      });
  });
</script>

<AppHead title="Bookmarks" />

<div class="flex h-full flex-1 flex-col gap-6 p-4">
  <h1 class="text-2xl font-bold">My Bookmarks</h1>

  <Form {...store.form()} resetOnSuccess class="flex flex-col gap-4 max-w-md">
    {#snippet children({ errors, processing })}
      <div class="grid gap-2">
        <Label for="title">Title</Label>
        <Input id="title" name="title" type="text" required placeholder="Svelte docs" />
        <InputError message={errors.title} />
      </div>

      <div class="grid gap-2">
        <Label for="url">URL</Label>
        <Input id="url" name="url" type="url" required placeholder="https://svelte.dev" />
        <InputError message={errors.url} />
      </div>

      <div class="grid gap-2">
        <Label for="description">Description (optional)</Label>
        <Input id="description" name="description" type="text" placeholder="The official docs" />
        <InputError message={errors.description} />
      </div>

      <div class="grid gap-2">
        <Label for="tags">Tags (comma-separated)</Label>
        <Input id="tags" name="tags" type="text" placeholder="svelte, docs, frontend" />
        <InputError message={errors.tags} />
      </div>

      <Button type="submit" disabled={processing} class="w-fit">Add bookmark</Button>
    {/snippet}
  </Form>
  <ul class="space-y-2">
    {#each bookmarks as bookmark (bookmark.id)}
      <li>
        <a href={bookmark.url} target="_blank" class="font-medium underline">{bookmark.title}</a>
        {#if bookmark.description}
          <span class="text-muted-foreground"> — {bookmark.description}</span>
        {/if}
        {#if bookmark.tags.length}
          <div class="mt-1 flex gap-1">
            {#each bookmark.tags as tag (tag.id)}
              <span class="rounded bg-muted px-2 py-0.5 text-xs">{tag.name}</span>
            {/each}
          </div>
        {/if}
      </li>
    {/each}
  </ul>


  <!-- search + tag filters -->
  <div class="flex flex-col gap-3">
    <Input
      type="text"
      placeholder="Search bookmarks..."
      bind:value={search}
      class="max-w-md"
    />

    {#if allTags.length}
      <div class="flex flex-wrap gap-2">
        <Button
          variant={selectedTag === null ? 'default' : 'outline'}
          size="sm"
          onclick={() => (selectedTag = null)}
        >
          All
        </Button>
        {#each allTags as tag (tag)}
          <Button
            variant={selectedTag === tag ? 'default' : 'outline'}
            size="sm"
            onclick={() => (selectedTag = tag)}
          >
            {tag}
          </Button>
        {/each}
      </div>
    {/if}
  </div>

  <!-- the list now renders `filtered` -->
  <ul class="space-y-2">
    {#each filtered as bookmark (bookmark.id)}
      <li>
        <a href={bookmark.url} target="_blank" class="font-medium underline">{bookmark.title}</a>
        {#if bookmark.description}
          <span class="text-muted-foreground"> — {bookmark.description}</span>
        {/if}
        {#if bookmark.tags.length}
          <div class="mt-1 flex gap-1">
            {#each bookmark.tags as tag (tag.id)}
              <button
                class="rounded bg-muted px-2 py-0.5 text-xs hover:bg-muted-foreground/20"
                onclick={() => (selectedTag = tag.name)}
              >
                {tag.name}
              </button>
            {/each}
          </div>
        {/if}
      </li>
    {/each}
  </ul>

  {#if filtered.length === 0}
    <p class="text-muted-foreground">No bookmarks match.</p>
  {/if}
</div>