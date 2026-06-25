# Bookmarks — Laravel + Svelte 5 + Inertia

A tagged, searchable, per-user bookmark manager built on the official Laravel Svelte starter kit.
Personal learning / reference project for the Laravel + Svelte 5 + Inertia stack.

## Stack

- **Laravel 13** — backend, routing, controllers
- **Svelte 5** (runes) + **TypeScript** — frontend
- **Inertia 3** — connects Laravel and Svelte with no separate API
- **Tailwind CSS** + **shadcn-svelte** — styling and UI components
- **Laravel Fortify** — authentication (registration, login)
- **Laravel Wayfinder** — type-safe route helpers
- **SQLite** — database (dev)

## What it does

- Create, view, edit, and delete bookmarks (title, URL, description)
- Organize bookmarks with tags
- Search and filter the bookmark list
- Per-user data: every bookmark belongs to a user; you only ever see your own

## Getting started

Requires PHP 8.3+, Composer, and Node.js.

```bash
# install dependencies
composer install
npm install

# environment + database
cp .env.example .env
php artisan key:generate
php artisan migrate

# run (serves PHP + Vite together)
composer run dev
```

App runs at `http://localhost:8000`. Register an account to get started.

## Project structure

```
app/
  Http/Controllers/   # BookmarkController, etc.
  Models/             # User, Bookmark
routes/
  web.php             # all routes (Inertia — no API layer)
database/migrations/  # schema
resources/js/
  pages/              # Inertia page components (one per controller render)
  components/         # reusable components (ui/ = shadcn-svelte)
  layouts/            # app layouts
  lib/                # utilities + shared rune modules
  types/              # TypeScript definitions
```

## Notes

This is a build-along reference project. The core idea of the stack:

> Inertia = Laravel controllers return a Svelte component + data (as props). No API, no `fetch`.

Detailed build notes are kept alongside the code.

## License

Personal project — not licensed for distribution.