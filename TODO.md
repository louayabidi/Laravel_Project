# TODO: Normalize Regimes Table and Establish Relationships

This file tracks progress on normalizing the database: making `regimes` a distinct table with regime-specific fields, linking `sante_mesure` to `regimes` via `regime_id`, maintaining the existing `user_id` link, removing denormalized regime fields from `sante_mesure` and `users`, and updating models, controller, and views accordingly.

## Steps

### Database Migrations
- [x] Step 1: Create migration `2025_09_28_160000_add_regime_fields_to_regimes_table.php` to add fields (`type_regime` enum, `valeur_cible` decimal, `prix` decimal, `description` text) to `regimes` table.
- [x] Step 2: Create migration `2025_09_28_160100_add_regime_id_to_sante_mesure_table.php` to add `regime_id` foreign key to `sante_mesure` table (constrained to `regimes.id`, onDelete 'cascade').
- [x] Step 3: Create migration `2025_09_28_160200_remove_regime_fields_from_sante_mesure_table.php` to drop `type_regime`, `valeur_cible`, `description` from `sante_mesure`.
- [x] Step 4: Create migration `2025_09_28_160300_remove_regime_fields_from_users_table.php` to drop `regime_id`, `type_regime`, `valeur_cible`, `description` from `users`.

### Model Updates
- [x] Step 5: Update `app/Models/Regime.php` - Add fillable array with new fields, define `hasMany` relationship to `SanteMesure`.
- [x] Step 6: Update `app/Models/SanteMesure.php` - Remove denormalized regime fields from fillable/casts, add `belongsTo` relationship to `Regime`.
- [x] Step 7: Update `app/Models/User.php` - Remove denormalized regime fields from fillable, remove `belongsTo` regime relationship (keep `hasMany` santeMesures).

### Application Logic Updates
- [x] Step 8: Update `app/Http/Controllers/SanteMesureController.php` - Modify create/store/update methods to associate/create regimes (e.g., select or create regime, link via regime_id), use relationships for data retrieval.
- [x] Step 9: Update views in `resources/views/sante_mesures/` (index.blade.php, create.blade.php, edit.blade.php, show.blade.php) - Replace direct regime field inputs/displays with regime dropdowns/joins (e.g., select from existing regimes or create new).

### Testing and Deployment
- [x] Step 10: Run migrations (`php artisan migrate`), verify schema with `php artisan tinker` (test relationships, e.g., create regime and link to sante_mesure).
- [ ] Step 11: Test application - Start server (`php artisan serve`), create/edit sante_mesure entries, ensure joins work and no errors in forms/tables.
- [ ] Step 12: If existing data needs migration, create a seeder or separate migration to populate regimes from denormalized fields (optional, confirm with user).
- [ ] Step 13: Clean up any conflicting old migrations if needed.

Progress will be updated as steps are completed. Current status: Starting with migrations.
