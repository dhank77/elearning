---
name: Clarity Learning
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#444653'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#757684'
  outline-variant: '#c4c5d5'
  surface-tint: '#3755c3'
  primary: '#00288e'
  on-primary: '#ffffff'
  primary-container: '#1e40af'
  on-primary-container: '#a8b8ff'
  inverse-primary: '#b8c4ff'
  secondary: '#006a61'
  on-secondary: '#ffffff'
  secondary-container: '#86f2e4'
  on-secondary-container: '#006f66'
  tertiary: '#4c2e00'
  on-tertiary: '#ffffff'
  tertiary-container: '#6b4200'
  on-tertiary-container: '#ffa929'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dde1ff'
  primary-fixed-dim: '#b8c4ff'
  on-primary-fixed: '#001453'
  on-primary-fixed-variant: '#173bab'
  secondary-fixed: '#89f5e7'
  secondary-fixed-dim: '#6bd8cb'
  on-secondary-fixed: '#00201d'
  on-secondary-fixed-variant: '#005049'
  tertiary-fixed: '#ffddb8'
  tertiary-fixed-dim: '#ffb95f'
  on-tertiary-fixed: '#2a1700'
  on-tertiary-fixed-variant: '#653e00'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 20px
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 8px
  container-max: 1280px
  gutter: 24px
  margin-desktop: 48px
  margin-mobile: 16px
---

## Brand & Style

The design system focuses on a **Modern / Corporate** aesthetic that prioritizes cognitive ease and a sense of academic achievement. The brand personality is that of a "Trusted Mentor"—reliable and professional, yet encouraging and accessible. 

Visual clarity is achieved through generous whitespace, high-contrast typography, and a structured information hierarchy. The emotional response should be one of calm confidence; students should feel that the platform is organized enough to manage their complex learning paths while being vibrant enough to keep them motivated. The style blends minimalist layouts with soft, approachable UI elements to reduce "learning fatigue."

## Colors

This design system utilizes a palette rooted in trust and momentum.

- **Primary (Royal Blue):** Used for core branding, navigation, and primary actions. It establishes authority and stability.
- **Secondary (Teal):** Used for progress indicators, success states, and interactive learning elements. It provides a vibrant, "living" contrast to the deep blue.
- **Tertiary (Amber):** Reserved for notifications, streaks, and gamification elements (like badges) to spark attention without causing alarm.
- **Neutral (Slate):** A range of cool grays used for text hierarchy and subtle UI borders to maintain a professional, clean environment.

## Typography

The design system exclusively uses **Inter** to ensure maximum legibility across all screen densities. 

- **Headlines:** Use Semi-Bold (600) or Bold (700) weights with tighter letter spacing to create a strong visual anchor for course titles and module headers.
- **Body Text:** Standardized at 16px for optimal readability in long-form lesson content. Line heights are kept generous (1.5x) to prevent eye strain during extended study sessions.
- **Labels:** Used for metadata (e.g., "Duration," "Difficulty"), utilizing Medium weights and slight tracking to differentiate from body prose.

## Layout & Spacing

The design system employs a **Fixed Grid** model for desktop to ensure content remains digestible and doesn't stretch awkwardly on ultra-wide monitors.

- **Grid:** A 12-column grid with a 1280px maximum container width.
- **Rhythm:** An 8px linear scale governs all padding and margins. 
- **Desktop:** 24px gutters provide significant "breathing room" between course cards and sidebar elements.
- **Mobile:** The layout collapses to a single column with 16px side margins. Horizontal scrolling "carousels" are preferred for course categories on mobile to preserve vertical space.

## Elevation & Depth

To maintain a "clean and professional" look, depth is communicated through **Tonal Layers** supplemented by **Ambient Shadows**.

- **Surface Levels:** The main background uses a very light gray (#F8FAFC). Cards and primary content containers are pure white (#FFFFFF), creating a natural lift.
- **Shadows:** Use extremely soft, diffused shadows (0px 4px 20px rgba(0, 0, 0, 0.05)) to suggest interactivity on hoverable cards.
- **Separation:** Low-contrast outlines (1px solid #E2E8F0) are used for inputs and static containers, while shadows are reserved for "active" or "floating" elements like modals and dropdowns.

## Shapes

The shape language is defined as **Rounded**, utilizing a 0.5rem (8px) base radius. This softens the "corporate" feel of the platform, making the learning environment feel more accessible and less intimidating.

- **Standard Elements:** Buttons, input fields, and small cards use the base 8px radius.
- **Large Containers:** Course thumbnails and main content areas use `rounded-lg` (16px) to emphasize the friendly, modern aesthetic.
- **Interactive Feedback:** Focus states should mirror the roundedness of the element with an additional 2px offset ring.

## Components

### Buttons
- **Primary:** Solid Royal Blue with white text. High emphasis.
- **Secondary:** Outlined with Teal text or subtle Teal tint background. Used for "Save for Later" or "Download Syllabus."
- **Ghost:** No border or background; used for navigation links and less frequent actions.

### Progress Indicators
- Use a thick 8px track with the Secondary Teal color for the fill. 
- Circular progress indicators are preferred for overall course completion; linear bars for individual lesson progress.

### Cards
- White background, 16px corner radius, and a subtle 1px border. 
- On hover, the border color shifts to Primary Blue and a soft shadow is applied.

### Input Fields
- Labels are always positioned above the field. 
- Use a 1px Slate border that thickens and changes to Primary Blue on focus.

### Chips & Tags
- Used for categories (e.g., "Design," "Coding"). 
- These should have a pill-shaped (rounded-full) appearance with a light tint of the primary color and a small icon for quick scanning.