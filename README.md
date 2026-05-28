# Event Ticketing

A Laravel 13 + Livewire 3 web app for selling event tickets with QR-code check-in.

## Features

### Public
- Browse all upcoming events on the homepage with title, date, description, price, and remaining capacity.
- View an individual event's full details.
- Register / log in (Laravel Breeze: email + password, forgot password, email verification).

### Buying tickets (logged-in users)
- Pick a quantity (1-10, capped by remaining capacity) on the event page.
- Click "Buy" to open a card payment modal — accepts any dummy details that match a real card format (e.g. `4242 4242 4242 4242`, exp `12/30`, CVV `123`). Validation is format-only; payment always succeeds via `MockPaymentService`.
- Each ticket gets its own UUID and QR code.
- After purchase you're redirected to the Dashboard.

### Dashboard (logged-in users)
- "My Tickets" — every ticket you own, grouped by event. Each event card shows all the QR codes for that event side-by-side.
- "Checked In" badge appears on a QR once it's been scanned at the door.
- "Upcoming Events" — events you don't have a ticket for yet.
- Profile section: edit name/email, change password, delete account (password-confirmed).

### Admin
Sub-nav across three sections. Admins are flagged by `users.is_admin`. The seeded admin is `admin@example.com` / `password`.

- **Events Overview** (`/admin`) — table of all events with tickets sold vs. capacity; "View Visitors" opens a per-event attendee list (email, ticket code, purchase time, check-in time).
- **Check-In Scanner** (`/admin/check-in`) — paste or scan a ticket UUID to mark it checked in. Rejects already-used tickets, unpaid tickets, and tickets for past events.
- **Analytics** (`/admin/analytics`) — total revenue, tickets sold, event count, check-in rate, top 5 events by sales, and a per-event breakdown with fill bars.

### Admin event CRUD
On the public events page, admins see extra buttons:
- "+ Create Event" — modal form for title, description, date/time, price, capacity. Past dates rejected on create.
- "Edit" / "Delete" buttons on each event card. Deleting an event cascade-deletes its tickets.

## Tech stack
- **Backend**: Laravel 13, PHP 8.3+
- **Frontend**: Livewire 3, Alpine.js, Tailwind CSS, Vite
- **Auth**: Laravel Breeze (Blade)
- **DB**: SQLite (default; swap via `.env`)
- **QR codes**: `simplesoftwareio/simple-qrcode`

## Setup (one-time)

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
New-Item -ItemType File database/database.sqlite
php artisan migrate --seed
npm install
```

Seeders create the admin user and a handful of sample events. Seeders are idempotent — safe to re-run.

## Running

```powershell
php artisan serve
php artisan queue:listen --tries=1 --timeout=0
npm run dev
```

Run each in its own terminal. Open http://127.0.0.1:8000.

`php artisan pail` (from the `composer dev` script) is skipped on Windows because it requires the `pcntl` extension. Read logs from `storage/logs/laravel.log` instead.

## Default credentials
- **Admin**: `admin@example.com` / `password`
- Register a fresh account for the regular-user flow.

## Routes (high level)
| Path | Purpose |
|---|---|
| `/` | Public events listing (with admin CRUD inline if admin) |
| `/events/{event}` | Event detail + purchase |
| `/register`, `/login`, `/forgot-password` | Breeze auth |
| `/dashboard` | User's tickets + upcoming events |
| `/profile` | Edit profile, password, delete account |
| `/admin` | Admin events overview |
| `/admin/events/{event}/visitors` | Per-event attendee list |
| `/admin/check-in` | QR / UUID scanner |
| `/admin/analytics` | Sales analytics |

## Notes
- Tickets are linked to a user by email string (`tickets.user_email`), not by `user_id`. Changing your account email orphans existing tickets.
- Email sending is configured to `log` — password reset links land in `storage/logs/laravel.log`, not a real inbox.
- The "card payment" is a mock — no real network call, no real validation. Treat as a placeholder for integrating Stripe or similar.
