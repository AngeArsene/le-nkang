---
name: design-announcement-show
description: Build a standalone, fully functional HTML/CSS/vanilla-JS prototype of the Le Nkang announcement detail page (announcements.show, /announcements/{slug}) with an Aurora dark-luxury look, a Sable-style app shell and Yamohub UX takeaways, fully responsive. Use whenever the user asks to design, prototype, mock up or redesign the Le Nkang announcement/listing detail page, "design-le-nkang", "maquette de la page annonce", or wants a pure HTML prototype to port later to Blade. Always load ui-ux-pro-max and taste-skill first.
---

# Le Nkang: announcement detail page prototype (Aurora dark luxury)

Act as a senior art director and front-end engineer. Build a standalone, high-fidelity, fully functional prototype of the announcement detail page (`announcements.show`, URL `/announcements/{slug}`) of Le Nkang, a classifieds site for adult companionship in Cameroon (French UI). Apply any extra instructions the user gave.

The prototype is pure HTML + CSS + vanilla JS: no framework, no build step, no backend. It must open by double-clicking `index.html`. It will be ported to Laravel Blade later, so keep it clean and structured.

## 0. Mandatory skills (load them before writing any code)

1. **ui-ux-pro-max** (nextlevelbuilder/ui-ux-pro-max-skill): design-system workflow for palette, type pairing, spacing scale, component states, accessibility and the pre-delivery checklist.
2. **taste-skill** (Leonxlnx/taste-skill): anti-generic pass, kills templated "AI-looking" output.
3. On conflict: the Aurora spec below wins on aesthetics, ui-ux-pro-max wins on usability and accessibility.

## 1. Discovery (do not skip)

1. Open `design/inspiration/` and study every image. Extract principles, never copy pixels, and never ship these images in the prototype.
2. **App shell reference: Sable** (`https://es10.premiummod.com/?design=sable`, screenshot in the folder). The prototype lives inside the same shell:
   - Left sidebar (desktop): Accueil, En ligne, Nouveautés de la semaine, Profils vidéo, then "Parcourir par ville" grouped by initial letter with counts, then language selector.
   - Top bar: search field, main nav links, "Publier mon annonce" (secondary), "Connexion" (primary).
   - Card styling to reuse for the "similar announcements" grid: tall portrait photo, "NOUVEAU" badge, play icon for video, status dot, serif name, `quartier · à partir de X FCFA`, tier badge (OR / ARGENT).
   - Footer with links and social icons.
3. **UX notes from Yamohub** (`https://yamohub.com/`, screenshot in the folder). Take these ideas:
   - Featured/ribbon treatment ("Reine de la semaine": highlighted border glow, corner ribbon, verified tick, view and like counters). Apply it to the announcement header when the listing is premium.
   - City chips with counts for the "same city" block.
   - Mobile bottom tab bar: Accueil, Recherche, Tendances, Messages, Profil.
   - A visible "Publier" CTA in the header, a theme toggle, a WhatsApp/Telegram contact shortcut.
   - Do not copy: explicit hero imagery, saturated orange/pink, floating buttons stacked over content, emoji used as icons, dense unstructured text.
4. Write a short audit (10 lines max): what to adopt from each reference, what to improve (hierarchy, discretion, contrast, performance on weak connections).

## 2. Design direction: Aurora dark luxury

- **Concept:** "Quiet luxury under northern lights." A dark, discreet, premium interface where the photos are the hero and a soft aurora glow gives depth.
- **Aurora = ambient only.** Layered, blurred `radial-gradient` blobs on a fixed background layer (teal/emerald base, deep violet, a touch of rose), opacity 12 to 25%, slow drift animation. Also use it for the gallery glow, the premium border and one promo banner. Never as a fill behind body text, and no flat purple-to-pink "AI" gradient on buttons.
- **Palette (CSS variables):** `--bg #0B0B10`, `--surface #14141B`, `--surface-2 #1C1C26`, `--text #F2EFE9`, `--muted #A7A3B3`, `--line rgba(255,255,255,.08)`, `--aurora-1 #2DD4BF`, `--aurora-2 #6D5BD0`, `--aurora-3 #E879A6`. One UI accent: champagne gold `--accent #C9A24B` for primary CTAs, prices and tier badges. Provide a working light theme too (toggle in the header, saved in `localStorage`, defaults to dark).
- **Typography:** elegant serif for titles and names (Cormorant Garamond or Playfair Display), clean sans for UI and body (Inter or DM Sans), 16px minimum body, `clamp()` for fluid headings. French diacritics must render perfectly. Fonts from Google Fonts with `font-display: swap` and system fallbacks.
- **Radius rule:** never the same radius on nested elements. `outer radius = inner radius + padding` (e.g. 28 = 16 + 12). Encode as CSS variables and apply to every card, image, badge, button and modal.
- **Surfaces:** subtle 1px borders, soft shadows, `backdrop-filter: blur` only on the sticky header, the tab bar and the lightbox.
- **Motion:** aurora drift, card hover lift and glow, gallery transitions, staggered reveal on scroll, skeleton shimmer on first paint. Respect `prefers-reduced-motion` (aurora becomes static, transitions shortened).
- **Do not:** stock-template looks, glassmorphism everywhere, neon, emoji as icons (use inline SVG icons), lorem ipsum, invented real people or numbers, any explicit imagery in the UI.

## 3. The page to build: announcement detail

Inside the shell above, the main column contains, in this order:

1. **Breadcrumb**: Accueil › Douala › Skinny Délicieuse.
2. **Gallery** for 0 to many images:
   - Large main image with prev/next buttons, swipe on touch, arrow keys, image counter (`2 / 5`), thumbnail strip (vertical or horizontal depending on width).
   - Lightbox (fullscreen, focus-trapped, `Esc` to close, pinch/double-click zoom, swipe between images).
   - 0 image state: elegant placeholder with an initial-letter monogram and an aurora glow.
3. **Header block**: `<h1>` title (serif), verified tick, tier badge (OR/ARGENT), quartier · ville, "Publiée il y a X jours", view counter, status dot (en ligne / hors ligne).
4. **Price block**: `à partir de 15 000 FCFA` (format with a thin space) and a small table of rates (e.g. 1 h, 2 h, nuit) shown as demo data.
5. **Description**: full text with "Lire la suite" expand/collapse when long.
6. **Details**: chips for services/languages/availability, working hours, quartier. Demo data only.
7. **Contact panel** (sticky sidebar on desktop, sticky bottom bar on mobile): `Écrire sur WhatsApp` (real `https://wa.me/…` link with a prefilled French message including the announcement title and URL), `Appeler` (`tel:` link), `Partager` (Web Share API with copy-link fallback and a toast), `Favori` heart toggle (persisted in `localStorage`, with a like counter update), `Signaler` (opens the report modal).
8. **Report modal**: reason select, optional message, client-side validation with clear error and helper states, success toast. Accessible (focus trap, `aria-modal`, `Esc`).
9. **Safety tips** card: short French tips (ne jamais payer d'avance, rencontrer en lieu sûr, etc.).
10. **"Du même quartier / Annonces similaires"**: grid of 4 to 8 cards (same card style as the Sable reference), horizontal scroll with snap on mobile.
11. **Footer** and the global **age gate 18+** modal (first visit only, remembered in `localStorage`, accessible).

Global shell behaviours that must work: sidebar (persistent on desktop, off-canvas drawer with overlay on smaller screens), search field (filters the "similar" cards live by title/quartier), theme toggle, bottom tab bar on mobile, skip link.

**Data:** put all demo data in one JS object at the top of `main.js` (`const announcement = {...}`, `const similar = [...]`) with the same field names Laravel will use (`title`, `slug`, `description`, `images[]`, `city`, `quartier`, `price`, `is_verified`, `tier`, `views`, `created_at`). Rendering reads from this object, so changing it changes the page. Support URL testing flags: `?images=0` (empty gallery), `?images=1`, `?images=8`, `?premium=1`, `?theme=light`.

**Images:** never hotlink and never use the inspiration photos. Generate local placeholder portraits as SVG/CSS artwork (abstract silhouettes on aurora gradients, tasteful and non-explicit) in `assets/img/`, each with real `alt` text.

## 4. Responsive requirements (non-negotiable)

Build mobile-first and verify at 360, 390, 768, 1024, 1280 and 1536 px.

- **< 768 px:** single column, burger header, bottom tab bar, gallery full-bleed with swipe and dots, sticky bottom CTA bar (WhatsApp primary, Appeler secondary) sitting above the tab bar without overlap, similar cards in 2 columns with horizontal snap, filters/sheets as bottom sheets.
- **768 to 1023 px:** gallery on top, content in one column with a contact card inline, sidebar as off-canvas drawer, 3-column similar grid.
- **>= 1024 px:** persistent sidebar, two-column layout (gallery + details left, sticky contact panel right), 4-column similar grid (5 at >= 1536 px).
- Use `dvh` not `vh`, `env(safe-area-inset-*)` for the tab bar and sticky CTAs, `aspect-ratio` on images and cards, `srcset`/`sizes` where raster images exist, `loading="lazy"` below the fold.
- No horizontal scroll of the page at any width. Touch targets 44 px minimum. Landscape phones must not break the tab bar or lightbox. Support text zoom to 200%.
- Weak connections: aurora in pure CSS (no video, no canvas), no libraries, total JS under ~30 KB unminified is the goal, fixed image dimensions to avoid layout shift.

## 5. Implementation

- **Folder (inside the project's `design/` folder):**
  - `design/prototype/announcements-show/index.html`
  - `design/prototype/announcements-show/assets/css/style.css`
  - `design/prototype/announcements-show/assets/js/main.js`
  - `design/prototype/announcements-show/assets/img/` (local placeholder artwork and icons)
- Pure HTML + CSS + vanilla JS only. No npm, no CDN scripts (Google Fonts allowed, with fallbacks so it still works offline).
- All design tokens as CSS custom properties (colors, type scale, spacing scale, radius pairs, shadows, aurora layers, z-index scale). Mobile-first media queries. BEM-style class names, one block per component, so each block maps to a future Blade component (`announcement-card`, `gallery`, `contact-panel`, `report-modal`, `tab-bar`…).
- Semantic HTML5, `lang="fr"`, one `<h1>`, skip link, alt text on every image, visible `:focus-visible` rings, ARIA for the gallery (`role="group"`, live region for the counter), toggles, drawer and modals, keyboard operable everywhere, focus returned to the trigger when modals close.
- `<title>` follows the pattern `Skinny Délicieuse – Le Nkang`, neutral favicon (inline SVG data URI), `<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">`, `<meta name="theme-color">`.
- JavaScript organised in small functions per feature (gallery, lightbox, favorites, share, report, drawer, theme, age gate, search), wrapped in `try/catch` around `localStorage`, no globals except the data objects.

## 6. Quality gate (run before finishing)

- Run the ui-ux-pro-max pre-delivery checklist: contrast (WCAG AA in both themes), focus, hover/active/disabled states, spacing consistency, responsive, reduced motion.
- Functional pass, click through every control: gallery prev/next/swipe/keys, lightbox open/close/zoom, favorite toggle persistence, share/copy-link toast, WhatsApp and call links, report modal validation and success, drawer, theme toggle, age gate, search filtering, expand/collapse description, every `?flag` state from section 3.
- Check the Aurora balance: ambient glow, not a rainbow. If it reads as "gradients everywhere", lower opacity and keep gold as the only UI accent.
- Verify every nested rounded element obeys `outer = inner + padding`.
- Verify the six viewports, no horizontal scroll, no overlapping fixed elements (tab bar, sticky CTA, toasts, age gate).
- Verify all French text, accents and FCFA formatting.

## 7. Output

1. A 10-line design rationale (concept, aurora recipe, palette, type, grid, what was adopted from Sable and Yamohub).
2. The created files with their paths (all under `design/prototype/announcements-show/`).
3. How to open and test the prototype (including the `?flag` states).
4. A short list of open questions or assumptions (logo, tier names, real image sizes, WhatsApp number format).
