<?php

return [
    
    '#module#' => '#module#',
    '#model#' => '#model#',
    'add_new' => 'Add new #model#',
    'edit' => 'Edit #model#',
    'back_to_#module#' => 'Back to #module#',
    'no_records' => 'No #module# found',
    'save_#model#' => 'save #model#',
    'search' => 'Search',
    'search_#module#' => 'Search #module#',
    'per_page' => 'Per page',
    'bulk_actions' => 'Bulk actions',
    'delete' => 'Delete',
    'apply' => 'Apply',
    'page' => 'Page',
    'of' => 'of',
    'order' => 'Order',
    'sort_by' => 'Sort by',
    'asc' => 'Ascending',
    'desc' => 'Descending',
    'actions' => 'Actions',
    'filter' => 'Filter',
    {if module.categories}
    'all_categories' => 'All categories',
    {/if}
    {if options.status}
    '#model#_status' => '#model|ucfirst# status',
    'activate' => 'Activate',
    'activated' => 'Activated',
    'all' => 'All',
    'deactivate' => 'Deactivate',
    'deactivated' => 'Deactivated',
    'sure_activate' => "Are you sure to activate #model# ?",
    'sure_deactivate' => "Are you sure to deactivate #model# ?",
    {/if}
    'sure_delete' => 'Are you sure to delete ?',
    [loop additional as item => title]
    '#item#' => '#title#',
    [/loop]
    'attributes' => [
        [loop attributes as key => name ]
        '#key#' => '#name#',
        [/loop]
        {if options.timestamps}
        'created_at' => 'Created date',
        'updated_at' => 'Updated date',
        {/if}
        {if options.status}
        'status' => 'Status'
        {/if}
    ],
    "events" => [
        'created' => '#model|ucfirst# created successfully',
        'updated' => '#model|ucfirst# updated successfully',
        'deleted' => '#model|ucfirst# deleted successfully',
        {if options.status}
        'activated' => '#model|ucfirst# activated successfully',
        'deactivated' => '#model|ucfirst# deactivated successfully'
        {/if}
    ]
    
];
