<?php

return [
    
    '#module#' => '#module#',
    '#model#' => '#model#',
    'add_new' => 'Add new #model#',
    'edit' => 'Edit #model#',
    'back_to_#module#' => 'Back to #module#',
    'no_records' => 'No #module# found',
    'save_#model#' => 'save #model#',
    'search' => 'search',
    'search_#module#' => 'Search #module#',
    'per_page' => 'per page',
    'bulk_actions' => 'bulk actions',
    'delete' => 'delete',
    'apply' => 'apply',
    'page' => 'Page',
    'of' => 'of',
    'order' => 'order',
    'sort_by' => 'Sort by',
    'asc' => 'Ascending',
    'desc' => 'Descending',
    'actions' => 'actions',
    'filter' => 'filter',
    {if module.categories}
    'all_categories' => 'All categories',
    {/if}
    {if options.status}
    '#model#_status' => '#model|ucfirst# status',
    'activate' => 'activate',
    'activated' => 'activated',
    'all' => 'All',
    'deactivate' => 'deactivate',
    'deactivated' => 'deactivated',
    'sure_activate' => "Are you sure to activate #model# ?",
    'sure_deactivate' => "Are you sure to deactivate #model# ?",
    {/if}
    'sure_delete' => 'Are you sure to delete ?',
    [loop additional as item => title]
    '#item#' => '#title#',
    [/loop]
    'attributes' => [
        [loop attributes as attribute]
        '#attribute#' => '#attribute#',
        [/loop]
        {if options.timestamps}
        'created_at' => 'created date',
        'updated_at' => 'updated date',
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
