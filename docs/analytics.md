# Music Label Income App - Analytics

## 1) Product goal
Build a web app for a music label to track track revenues, distribute artist shares, and generate reports for artists and admins.

## 2) Roles and permissions
- Artist:
  - Can log in.
  - Can view track cards.
  - Can view artist cards.
  - Can generate own revenue report by period or selected tracks.
- Label admin:
  - Can log in.
  - Can view all track and artist cards.
  - Can change revenue share percentages for a single track or for a group of tracks.
  - Can generate revenue reports for any artist.

## 3) Domain entities
- User: auth identity, role (`artist` or `admin`), optional link to artist profile.
- Artist: name, stage name, metadata.
- Track: title, code, release date, metadata.
- ArtistTrack (pivot): links artist to track and stores share percent for that artist in that track.
- RevenueEntry: track revenue event with amount and date.
- Report: stored generated report metadata and total value.

## 4) Core business rules
1. Artist income is calculated from track revenue entries and artist share percent for each track.
2. Reports are generated:
   - by period (`from`/`to`);
   - optionally only for selected tracks.
3. If track lineup or shares change, report values should reflect latest data.
4. Admin can mass-update share percentages for selected tracks.

## 5) Main UI tabs
- Tracks tab: list of track cards with full info.
- Artists tab: list of artist cards with full info.
- Reports tab (admin only): create and view reports.

## 6) Sprint decomposition (Scrum-like)
### Sprint 0 - Analytics and setup
- Confirm data model and roles.
- Prepare project skeleton and authentication.

### Sprint 1 - Development (MVP)
- Build DB schema and Eloquent relationships.
- Implement auth and role middleware.
- Implement track/artist cards pages.
- Implement artist report generation by period and selected tracks.
- Implement admin share editing (single + bulk).
- Implement admin reports page.

### Sprint 2 - Testing and hardening
- Feature tests for access control and report calculations.
- Manual smoke test for all tabs and core flows.
- Final cleanup and run test suite.

## 7) Clarifications to resolve later
1. Currency format (RUB/USD).
2. Whether report exports (CSV/PDF) are needed in MVP.
3. Whether revenue should be manually entered or imported from external systems.
