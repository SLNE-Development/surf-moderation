<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Livewire\DatabaseNotifications;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentIcon;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        DatabaseNotifications::pollingInterval(null);

        $this->registerFASIcons();

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->registration()
            ->login()
            ->passwordReset()
            ->profile()
            ->emailVerification()
            ->sidebarFullyCollapsibleOnDesktop()
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->databaseNotifications()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    private function registerFASIcons()
    {
        FilamentIcon::register([
            // --- Panels ---
            'panels::global-search.field' => 'fas-magnifying-glass',
            'panels::pages.dashboard.actions.filter' => 'fas-filter',
            'panels::pages.dashboard.navigation-item' => 'fas-gauge',
            'panels::pages.password-reset.request-password-reset.actions.login' => 'fas-right-to-bracket',
            'panels::pages.password-reset.request-password-reset.actions.login.rtl' => 'fas-right-to-bracket',
            'panels::resources.pages.edit-record.navigation-item' => 'fas-pen-to-square',
            'panels::resources.pages.manage-related-records.navigation-item' => 'fas-layer-group',
            'panels::resources.pages.view-record.navigation-item' => 'fas-eye',
            'panels::sidebar.collapse-button' => 'fas-angles-left',
            'panels::sidebar.collapse-button.rtl' => 'fas-angles-right',
            'panels::sidebar.expand-button' => 'fas-angles-right',
            'panels::sidebar.expand-button.rtl' => 'fas-angles-left',
            'panels::sidebar.group.collapse-button' => 'fas-chevron-up',
            'panels::tenant-menu.billing-button' => 'fas-file-invoice-dollar',
            'panels::tenant-menu.profile-button' => 'fas-user',
            'panels::tenant-menu.registration-button' => 'fas-id-card',
            'panels::tenant-menu.toggle-button' => 'fas-bars',
            'panels::theme-switcher.light-button' => 'fas-sun',
            'panels::theme-switcher.dark-button' => 'fas-moon',
            'panels::theme-switcher.system-button' => 'fas-desktop',
            'panels::topbar.close-sidebar-button' => 'fas-xmark',
            'panels::topbar.open-sidebar-button' => 'fas-bars',
            'panels::topbar.group.toggle-button' => 'fas-chevron-down',
            'panels::topbar.open-database-notifications-button' => 'fas-bell',
            'panels::user-menu.profile-item' => 'fas-user',
            'panels::user-menu.logout-button' => 'fas-right-from-bracket',
            'panels::widgets.account.logout-button' => 'fas-right-from-bracket',
            'panels::widgets.filament-info.open-documentation-button' => 'fas-book-open',
            'panels::widgets.filament-info.open-github-button' => 'fab-github',

            // --- Form Builder ---
            'forms::components.builder.actions.clone' => 'fas-clone',
            'forms::components.builder.actions.collapse' => 'fas-chevron-up',
            'forms::components.builder.actions.delete' => 'fas-trash',
            'forms::components.builder.actions.expand' => 'fas-chevron-down',
            'forms::components.builder.actions.move-down' => 'fas-arrow-down',
            'forms::components.builder.actions.move-up' => 'fas-arrow-up',
            'forms::components.builder.actions.reorder' => 'fas-up-down-left-right',

            'forms::components.checkbox-list.search-field' => 'fas-magnifying-glass',

            'forms::components.file-upload.editor.actions.drag-crop' => 'fas-crop',
            'forms::components.file-upload.editor.actions.drag-move' => 'fas-up-down-left-right',
            'forms::components.file-upload.editor.actions.flip-horizontal' => 'fas-arrows-left-right',
            'forms::components.file-upload.editor.actions.flip-vertical' => 'fas-arrows-up-down',
            'forms::components.file-upload.editor.actions.move-down' => 'fas-arrow-down',
            'forms::components.file-upload.editor.actions.move-left' => 'fas-arrow-left',
            'forms::components.file-upload.editor.actions.move-right' => 'fas-arrow-right',
            'forms::components.file-upload.editor.actions.move-up' => 'fas-arrow-up',
            'forms::components.file-upload.editor.actions.rotate-left' => 'fas-rotate-left',
            'forms::components.file-upload.editor.actions.rotate-right' => 'fas-rotate-right',
            'forms::components.file-upload.editor.actions.zoom-100' => 'fas-magnifying-glass-minus',
            'forms::components.file-upload.editor.actions.zoom-in' => 'fas-magnifying-glass-plus',
            'forms::components.file-upload.editor.actions.zoom-out' => 'fas-magnifying-glass-minus',

            'forms::components.key-value.actions.delete' => 'fas-trash',
            'forms::components.key-value.actions.reorder' => 'fas-up-down-left-right',

            'forms::components.repeater.actions.clone' => 'fas-clone',
            'forms::components.repeater.actions.collapse' => 'fas-chevron-up',
            'forms::components.repeater.actions.delete' => 'fas-trash',
            'forms::components.repeater.actions.expand' => 'fas-chevron-down',
            'forms::components.repeater.actions.move-down' => 'fas-arrow-down',
            'forms::components.repeater.actions.move-up' => 'fas-arrow-up',
            'forms::components.repeater.actions.reorder' => 'fas-up-down-left-right',

            'forms::components.select.actions.create-option' => 'fas-plus',
            'forms::components.select.actions.edit-option' => 'fas-pen',

            'forms::components.text-input.actions.hide-password' => 'fas-eye-slash',
            'forms::components.text-input.actions.show-password' => 'fas-eye',

            'forms::components.toggle-buttons.boolean.false' => 'far-circle-xmark',
            'forms::components.toggle-buttons.boolean.true' => 'far-circle-check',

            'forms::components.wizard.completed-step' => 'fas-circle-check',

            // --- Table Builder ---
            'tables::actions.disable-reordering' => 'fas-lock',
            'tables::actions.enable-reordering' => 'fas-up-down-left-right',
            'tables::actions.filter' => 'fas-filter',
            'tables::actions.group' => 'fas-object-group',
            'tables::actions.open-bulk-actions' => 'fas-layer-group',
            'tables::actions.toggle-columns' => 'fas-table-columns',

            'tables::columns.collapse-button' => 'fas-chevron-up',
            'tables::columns.icon-column.false' => 'far-circle-xmark',
            'tables::columns.icon-column.true' => 'far-circle-check',

            'tables::empty-state' => 'fas-folder-open',

            'tables::filters.query-builder.constraints.boolean' => 'fas-toggle-on',
            'tables::filters.query-builder.constraints.date' => 'fas-calendar-days',
            'tables::filters.query-builder.constraints.number' => 'fas-hashtag',
            'tables::filters.query-builder.constraints.relationship' => 'fas-link',
            'tables::filters.query-builder.constraints.select' => 'fas-list',
            'tables::filters.query-builder.constraints.text' => 'fas-font',

            'tables::filters.remove-all-button' => 'fas-ban',
            'tables::grouping.collapse-button' => 'fas-chevron-up',

            'tables::header-cell.sort-asc-button' => 'fas-arrow-up-short-wide',
            'tables::header-cell.sort-button' => 'fas-sort',
            'tables::header-cell.sort-desc-button' => 'fas-arrow-down-wide-short',

            'tables::reorder.handle' => 'fas-grip-lines',
            'tables::search-field' => 'fas-magnifying-glass',

            // --- Notifications ---
            'notifications::database.modal.empty-state' => 'fas-inbox',
            'notifications::notification.close-button' => 'fas-xmark',
            'notifications::notification.danger' => 'fas-circle-exclamation',
            'notifications::notification.info' => 'fas-circle-info',
            'notifications::notification.success' => 'fas-circle-check',
            'notifications::notification.warning' => 'fas-triangle-exclamation',

            // --- Actions ---
            'actions::action-group' => 'fas-layer-group',
            'actions::create-action.grouped' => 'fas-plus',
            'actions::delete-action' => 'fas-trash',
            'actions::delete-action.grouped' => 'fas-trash',
            'actions::delete-action.modal' => 'fas-trash-can',
            'actions::detach-action' => 'fas-link-slash',
            'actions::detach-action.modal' => 'fas-link-slash',
            'actions::dissociate-action' => 'fas-chain-broken',
            'actions::dissociate-action.modal' => 'fas-chain-broken',
            'actions::edit-action' => 'fas-pen',
            'actions::edit-action.grouped' => 'fas-pen',
            'actions::export-action.grouped' => 'fas-file-export',
            'actions::force-delete-action' => 'fas-skull-crossbones',
            'actions::force-delete-action.grouped' => 'fas-skull-crossbones',
            'actions::force-delete-action.modal' => 'fas-skull',
            'actions::import-action.grouped' => 'fas-file-import',
            'actions::modal.confirmation' => 'fas-circle-question',
            'actions::replicate-action' => 'fas-copy',
            'actions::replicate-action.grouped' => 'fas-copy',
            'actions::restore-action' => 'fas-trash-arrow-up',
            'actions::restore-action.grouped' => 'fas-trash-arrow-up',
            'actions::restore-action.modal' => 'fas-trash-restore',
            'actions::view-action' => 'fas-eye',
            'actions::view-action.grouped' => 'fas-eye',

            // --- Infolist Builder ---
            'infolists::components.icon-entry.false' => 'far-circle-xmark',
            'infolists::components.icon-entry.true' => 'far-circle-check',

            // --- UI Components ---
            'badge.delete-button' => 'fas-xmark',
            'breadcrumbs.separator' => 'fas-chevron-right',
            'breadcrumbs.separator.rtl' => 'fas-chevron-left',
            'modal.close-button' => 'fas-xmark',
            'pagination.first-button' => 'fas-angles-left',
            'pagination.first-button.rtl' => 'fas-angles-right',
            'pagination.last-button' => 'fas-angles-right',
            'pagination.last-button.rtl' => 'fas-angles-left',
            'pagination.next-button' => 'fas-angle-right',
            'pagination.next-button.rtl' => 'fas-angle-left',
            'pagination.previous-button' => 'fas-angle-left',
            'pagination.previous-button.rtl' => 'fas-angle-right',
            'section.collapse-button' => 'fas-chevron-up',
        ]);
    }
}
