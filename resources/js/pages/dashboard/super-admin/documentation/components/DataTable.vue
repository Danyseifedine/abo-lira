<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@ui/card';
import { Badge } from '@ui/badge';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@ui/table';
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@ui/collapsible';
import { ChevronDown } from 'lucide-vue-next';
</script>

<template>
    <div class="space-y-6">
        <!-- Overview -->
        <Card>
            <CardHeader>
                <CardTitle>DataTable Component</CardTitle>
                <CardDescription>
                    A powerful, feature-rich data table component built on TanStack Vue Table with server-side and client-side support.
                </CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
                <div class="border-l-4 border-primary pl-4">
                    <h4 class="font-semibold mb-2">✨ Key Features</h4>
                    <ul class="space-y-1 text-sm text-muted-foreground">
                        <li>• Server-side & client-side pagination</li>
                        <li>• Multi-column search with debouncing</li>
                        <li>• Flexible filtering system</li>
                        <li>• Column sorting & visibility toggles</li>
                        <li>• Row selection with bulk actions</li>
                        <li>• Customizable column types (text, badge, date, toggle, actions)</li>
                        <li>• Built-in integration with Laravel backend via HasDataTable trait</li>
                        <li>• Full TypeScript support</li>
                    </ul>
                </div>
            </CardContent>
        </Card>

        <!-- Architecture -->
        <Card>
            <CardHeader>
                <CardTitle>📐 Architecture</CardTitle>
            </CardHeader>
            <CardContent class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="border rounded-lg p-4 bg-blue-500/5">
                        <h4 class="font-semibold text-sm mb-2">1. Backend (Laravel)</h4>
                        <ul class="text-xs space-y-1 text-muted-foreground">
                            <li>• <code>HasDataTable</code> trait</li>
                            <li>• Service layer config</li>
                            <li>• Controller orchestration</li>
                        </ul>
                    </div>
                    <div class="border rounded-lg p-4 bg-green-500/5">
                        <h4 class="font-semibold text-sm mb-2">2. Frontend (Vue)</h4>
                        <ul class="text-xs space-y-1 text-muted-foreground">
                            <li>• DataTable component</li>
                            <li>• Column definitions</li>
                            <li>• Type interfaces</li>
                        </ul>
                    </div>
                    <div class="border rounded-lg p-4 bg-purple-500/5">
                        <h4 class="font-semibold text-sm mb-2">3. State Management</h4>
                        <ul class="text-xs space-y-1 text-muted-foreground">
                            <li>• <code>useDatatable</code> composable</li>
                            <li>• <code>useFilters</code> composable</li>
                            <li>• TanStack Vue Table</li>
                        </ul>
                    </div>
                </div>
            </CardContent>
        </Card>

        <!-- Basic Usage -->
        <Card>
            <CardHeader>
                <CardTitle>🚀 Basic Usage</CardTitle>
            </CardHeader>
            <CardContent class="space-y-4">
                <pre class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"><code>&lt;script setup lang="ts"&gt;
import DataTable from '@/common/components/dashboards/datatable/Datatable.vue';
import { userColumns } from './datatable/userColumns';
import type { User } from './datatable/type';

const props = defineProps&lt;{
    users: {
        data: User[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    filters: {
        search?: string;
        sort?: string;
        direction?: 'asc' | 'desc';
        per_page?: number;
    };
}&gt;();

const tableConfig = {
    searchable: true,
    searchPlaceholder: 'Search users...',
    selectable: true,
    columnVisibility: true,
    perPageSelector: true,
    perPageOptions: [10, 25, 50, 100],
    serverSide: true,
    pagination: props.users,
    filters: props.filters,
    routeName: 'super-admin.users.index',
    preserveScroll: true,
};

const handleRowClick = (user: User) =&gt; {
    router.get(route('super-admin.users.show', user.id));
};
&lt;/script&gt;

&lt;template&gt;
    &lt;DataTable
        :columns="userColumns"
        :data="users.data"
        :config="tableConfig"
        @row-click="handleRowClick"
    &gt;
        &lt;!-- Optional: Custom toolbar actions --&gt;
        &lt;template #toolbar="{ table }"&gt;
            &lt;Button v-if="table.getFilteredSelectedRowModel().rows.length &gt; 0"&gt;
                Delete ({ { table.getFilteredSelectedRowModel().rows.length } })
            &lt;/Button&gt;
        &lt;/template&gt;

        &lt;!-- Optional: Custom filters --&gt;
        &lt;template #filters&gt;
            &lt;DashboardSelect v-model="localFilters.role" :options="roles" /&gt;
        &lt;/template&gt;
    &lt;/DataTable&gt;
&lt;/template&gt;</code></pre>
            </CardContent>
        </Card>

        <!-- Config Options -->
        <Card>
            <CardHeader>
                <CardTitle>⚙️ Configuration Options</CardTitle>
            </CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[200px]">Property</TableHead>
                            <TableHead class="w-[150px]">Type</TableHead>
                            <TableHead class="w-[120px]">Default</TableHead>
                            <TableHead>Description</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow>
                            <TableCell class="font-mono text-sm">searchable</TableCell>
                            <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                            <TableCell><code>true</code></TableCell>
                            <TableCell>Enable search functionality</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">searchPlaceholder</TableCell>
                            <TableCell><Badge variant="outline">string</Badge></TableCell>
                            <TableCell><code>"Search..."</code></TableCell>
                            <TableCell>Placeholder text for search input</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">selectable</TableCell>
                            <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                            <TableCell><code>true</code></TableCell>
                            <TableCell>Enable row selection with checkboxes</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">columnVisibility</TableCell>
                            <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                            <TableCell><code>true</code></TableCell>
                            <TableCell>Enable column visibility toggle</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">perPageSelector</TableCell>
                            <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                            <TableCell><code>true</code></TableCell>
                            <TableCell>Enable per-page dropdown selector</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">perPageOptions</TableCell>
                            <TableCell><Badge variant="outline">number[]</Badge></TableCell>
                            <TableCell><code>[10, 20, 30, 50, 100]</code></TableCell>
                            <TableCell>Options for per-page selector</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">filterable</TableCell>
                            <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                            <TableCell><code>false</code></TableCell>
                            <TableCell>Enable filter panel</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">serverSide</TableCell>
                            <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                            <TableCell><code>false</code></TableCell>
                            <TableCell>Use server-side pagination/sorting</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">pagination</TableCell>
                            <TableCell><Badge variant="outline">PaginationData</Badge></TableCell>
                            <TableCell><code>undefined</code></TableCell>
                            <TableCell>Server pagination data (required if serverSide: true)</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">filters</TableCell>
                            <TableCell><Badge variant="outline">FilterData</Badge></TableCell>
                            <TableCell><code>undefined</code></TableCell>
                            <TableCell>Current filter state</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">routeName</TableCell>
                            <TableCell><Badge variant="outline">string</Badge></TableCell>
                            <TableCell><code>undefined</code></TableCell>
                            <TableCell>Inertia route name for navigation</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">preserveState</TableCell>
                            <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                            <TableCell><code>false</code></TableCell>
                            <TableCell>Preserve component state on navigation</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">preserveScroll</TableCell>
                            <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                            <TableCell><code>true</code></TableCell>
                            <TableCell>Preserve scroll position on navigation</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>
        </Card>

        <!-- Column Types -->
        <Card>
            <CardHeader>
                <CardTitle>📋 Column Types</CardTitle>
                <CardDescription>
                    All available column types and their configurations
                </CardDescription>
            </CardHeader>
            <CardContent class="space-y-6">
                <div class="border-l-4 border-primary pl-4 bg-primary/5 p-3 rounded">
                    <h4 class="font-semibold mb-2 text-sm">📦 Available Column Types</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm">
                        <code class="bg-muted px-2 py-1 rounded">textColumn()</code>
                        <code class="bg-muted px-2 py-1 rounded">badgeColumn()</code>
                        <code class="bg-muted px-2 py-1 rounded">dateColumn()</code>
                        <code class="bg-muted px-2 py-1 rounded">toggleColumn()</code>
                        <code class="bg-muted px-2 py-1 rounded">counterColumn()</code>
                        <code class="bg-muted px-2 py-1 rounded">selectColumn()</code>
                        <code class="bg-muted px-2 py-1 rounded">actionsColumn()</code>
                        <code class="bg-green-500/20 px-2 py-1 rounded font-semibold">imageColumn() 🆕</code>
                        <code class="bg-green-500/20 px-2 py-1 rounded font-semibold">linkColumn() 🆕</code>
                        <code class="bg-muted px-2 py-1 rounded">customColumn()</code>
                    </div>
                    <p class="text-xs text-muted-foreground mt-2">
                        Import from: <code>@/common/components/dashboards/datatable/columnDef</code>
                    </p>
                </div>

                <!-- Text Column -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full">
                        <ChevronDown class="h-5 w-5" />
                        <span>textColumn</span>
                        <Badge variant="secondary" class="ml-2">Text</Badge>
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Display text content with optional formatting and sorting.
                        </p>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Usage Example</h4>
                            <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>import { textColumn } from '@/common/components/dashboards/datatable/columnDef';

textColumn('name', 'Full Name', {
    sortable: true,
    searchable: true,
    visible: true,
    className: 'font-medium',
    format: (value) =&gt; value?.toUpperCase() || 'N/A',
})</code></pre>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Properties</h4>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Property</TableHead>
                                        <TableHead>Type</TableHead>
                                        <TableHead>Default</TableHead>
                                        <TableHead>Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">key</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><span class="text-red-500">required</span></TableCell>
                                        <TableCell>Data property key (e.g., 'name', 'email')</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">label</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><code>key</code></TableCell>
                                        <TableCell>Column header label</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">sortable</TableCell>
                                        <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                                        <TableCell><code>true</code></TableCell>
                                        <TableCell>Enable column sorting</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">searchable</TableCell>
                                        <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                                        <TableCell><code>false</code></TableCell>
                                        <TableCell>Include in global search (backend only)</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">visible</TableCell>
                                        <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                                        <TableCell><code>true</code></TableCell>
                                        <TableCell>Initial visibility state</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">className</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><code>undefined</code></TableCell>
                                        <TableCell>CSS classes for cell content</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">headerClassName</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><code>undefined</code></TableCell>
                                        <TableCell>CSS classes for header</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">width</TableCell>
                                        <TableCell><Badge variant="outline">number | string</Badge></TableCell>
                                        <TableCell><code>undefined</code></TableCell>
                                        <TableCell>Fixed column width (e.g., 200, '200px')</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">format</TableCell>
                                        <TableCell><Badge variant="outline">(value: any) => string</Badge></TableCell>
                                        <TableCell><code>undefined</code></TableCell>
                                        <TableCell>Custom formatter function</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Badge Column -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full">
                        <ChevronDown class="h-5 w-5" />
                        <span>badgeColumn</span>
                        <Badge variant="secondary" class="ml-2">Badge</Badge>
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Display data as styled badges with custom variants. Supports single badges or multiple badges for arrays.
                        </p>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Usage Example</h4>
                            <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>import { badgeColumn } from '@/common/components/dashboards/datatable/columnDef';

// Single badge with custom variants
badgeColumn('status', 'Status', {
    variants: {
        'active': 'default',
        'inactive': 'secondary',
        'pending': 'warning',
    },
    defaultVariant: 'secondary',
})

// Multiple badges (for arrays like roles)
badgeColumn('roles', 'Roles', {
    multiple: true,
})</code></pre>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Properties</h4>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Property</TableHead>
                                        <TableHead>Type</TableHead>
                                        <TableHead>Default</TableHead>
                                        <TableHead>Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">key</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><span class="text-red-500">required</span></TableCell>
                                        <TableCell>Data property key</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">label</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><code>key</code></TableCell>
                                        <TableCell>Column header label</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">variants</TableCell>
                                        <TableCell><Badge variant="outline">Record&lt;string, string&gt;</Badge></TableCell>
                                        <TableCell><code>{}</code></TableCell>
                                        <TableCell>Map values to badge variants (default, secondary, destructive, outline)</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">defaultVariant</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><code>'default'</code></TableCell>
                                        <TableCell>Fallback variant if value not in variants map</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">multiple</TableCell>
                                        <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                                        <TableCell><code>false</code></TableCell>
                                        <TableCell>Display multiple badges for array values</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Date Column -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full">
                        <ChevronDown class="h-5 w-5" />
                        <span>dateColumn</span>
                        <Badge variant="secondary" class="ml-2">Date</Badge>
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Display dates with custom formatting or relative time (e.g., "2 days ago").
                        </p>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Usage Example</h4>
                            <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>import { dateColumn } from '@/common/components/dashboards/datatable/columnDef';

// Relative time format
dateColumn('created_at', 'Created', {
    relative: true,
    sortable: true,
})

// Custom date format
dateColumn('updated_at', 'Updated', {
    format: 'MMM DD, YYYY',
    sortable: true,
})</code></pre>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Properties</h4>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Property</TableHead>
                                        <TableHead>Type</TableHead>
                                        <TableHead>Default</TableHead>
                                        <TableHead>Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">key</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><span class="text-red-500">required</span></TableCell>
                                        <TableCell>Data property key</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">label</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><code>key</code></TableCell>
                                        <TableCell>Column header label</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">sortable</TableCell>
                                        <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                                        <TableCell><code>true</code></TableCell>
                                        <TableCell>Enable column sorting</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">relative</TableCell>
                                        <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                                        <TableCell><code>false</code></TableCell>
                                        <TableCell>Display relative time (e.g., "2 hours ago")</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">format</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><code>'MMM DD, YYYY'</code></TableCell>
                                        <TableCell>Date format string (ignored if relative: true)</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Toggle Column -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full">
                        <ChevronDown class="h-5 w-5" />
                        <span>toggleColumn</span>
                        <Badge variant="secondary" class="ml-2">Toggle</Badge>
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Interactive toggle switch with callback support and conditional disabling.
                        </p>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Usage Example</h4>
                            <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>import { toggleColumn } from '@/common/components/dashboards/datatable/columnDef';
import { router } from '@inertiajs/vue3';

toggleColumn('is_active', 'Active', {
    onToggle: (value: boolean, user: User, control) =&gt; {
        router.patch(route('super-admin.users.toggle-status', user.id),
            { is_active: value },
            {
                preserveScroll: true,
                onSuccess: (page) =&gt; {
                    const response = page.props.flash?.toast;
                    if (response?.success === false) {
                        control.revert(); // Revert toggle on error
                    }
                }
            }
        );
    },
    disabled: (user: User) =&gt; {
        return user.role === 'super-admin';
    },
    toggledWhen: (value: any) =&gt; {
        return convertToBoolean(value);
    },
    size: 'sm',
    className: 'flex justify-center',
})</code></pre>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Properties</h4>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Property</TableHead>
                                        <TableHead>Type</TableHead>
                                        <TableHead>Default</TableHead>
                                        <TableHead>Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">key</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><span class="text-red-500">required</span></TableCell>
                                        <TableCell>Data property key</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">label</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><code>key</code></TableCell>
                                        <TableCell>Column header label</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">onToggle</TableCell>
                                        <TableCell><Badge variant="outline">(value, row, control) => void</Badge></TableCell>
                                        <TableCell><code>undefined</code></TableCell>
                                        <TableCell>Callback when toggle is clicked. Receives new value, row data, and control object</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">disabled</TableCell>
                                        <TableCell><Badge variant="outline">(row) => boolean</Badge></TableCell>
                                        <TableCell><code>undefined</code></TableCell>
                                        <TableCell>Function to determine if toggle should be disabled</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">toggledWhen</TableCell>
                                        <TableCell><Badge variant="outline">(value, row) => boolean</Badge></TableCell>
                                        <TableCell><code>undefined</code></TableCell>
                                        <TableCell>Custom logic to determine toggle state</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">size</TableCell>
                                        <TableCell><Badge variant="outline">'sm' | 'default' | 'lg'</Badge></TableCell>
                                        <TableCell><code>'default'</code></TableCell>
                                        <TableCell>Toggle switch size</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>

                        <div class="border-l-4 border-blue-500 pl-4 bg-blue-500/5 p-3 rounded">
                            <h5 class="font-semibold text-sm mb-2">🎛️ Control Object</h5>
                            <p class="text-xs text-muted-foreground mb-2">The control object passed to onToggle provides:</p>
                            <ul class="text-xs space-y-1">
                                <li>• <code>control.revert()</code> - Revert toggle to previous state</li>
                                <li>• <code>control.toggle()</code> - Programmatically toggle</li>
                                <li>• <code>control.dontToggle()</code> - Prevent toggle action</li>
                            </ul>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Counter Column -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full">
                        <ChevronDown class="h-5 w-5" />
                        <span>counterColumn</span>
                        <Badge variant="secondary" class="ml-2">Counter</Badge>
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Display auto-incrementing row numbers.
                        </p>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Usage Example</h4>
                            <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>import { counterColumn } from '@/common/components/dashboards/datatable/columnDef';

counterColumn('#', {
    startFrom: 1,
})</code></pre>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Properties</h4>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Property</TableHead>
                                        <TableHead>Type</TableHead>
                                        <TableHead>Default</TableHead>
                                        <TableHead>Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">label</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><code>'#'</code></TableCell>
                                        <TableCell>Column header label</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">startFrom</TableCell>
                                        <TableCell><Badge variant="outline">number</Badge></TableCell>
                                        <TableCell><code>1</code></TableCell>
                                        <TableCell>Starting number for counter</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Select Column -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full">
                        <ChevronDown class="h-5 w-5" />
                        <span>selectColumn</span>
                        <Badge variant="secondary" class="ml-2">Checkbox</Badge>
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Display checkboxes for row selection with "select all" functionality.
                        </p>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Usage Example</h4>
                            <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>import { selectColumn } from '@/common/components/dashboards/datatable/columnDef';

selectColumn() // No configuration needed</code></pre>
                        </div>

                        <div class="border-l-4 border-blue-500 pl-4 bg-blue-500/5 p-3 rounded">
                            <h5 class="font-semibold text-sm mb-2">💡 Note</h5>
                            <p class="text-xs text-muted-foreground">
                                Use <code>counterColumn()</code> for row numbers or <code>selectColumn()</code> for checkboxes - they occupy the same position.
                            </p>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Actions Column -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full">
                        <ChevronDown class="h-5 w-5" />
                        <span>actionsColumn</span>
                        <Badge variant="secondary" class="ml-2">Actions</Badge>
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Dropdown menu with action items (view, edit, delete, etc.) with icons and conditional visibility.
                        </p>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Usage Example</h4>
                            <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>import { actionsColumn } from '@/common/components/dashboards/datatable/columnDef';
import { Copy, Eye, Edit, Trash2 } from 'lucide-vue-next';

actionsColumn([
    {
        label: 'Copy ID',
        icon: Copy,
        onClick: (user) =&gt; {
            navigator.clipboard.writeText(user.id.toString());
        },
    },
    { separator: true, label: 'Separator' },
    {
        label: 'View',
        icon: Eye,
        href: (user) =&gt; route('super-admin.users.show', user.id),
    },
    {
        label: 'Edit',
        icon: Edit,
        href: (user) =&gt; route('super-admin.users.edit', user.id),
    },
    { separator: true, label: 'Separator' },
    {
        label: 'Delete',
        icon: Trash2,
        destructive: true,
        show: (user) =&gt; user.role !== 'super-admin',
        onClick: (user) =&gt; {
            openDeleteDialog(user);
        },
    },
])</code></pre>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Action Item Properties</h4>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Property</TableHead>
                                        <TableHead>Type</TableHead>
                                        <TableHead>Required</TableHead>
                                        <TableHead>Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">label</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><Badge variant="destructive">Yes</Badge></TableCell>
                                        <TableCell>Action label text</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">icon</TableCell>
                                        <TableCell><Badge variant="outline">Component</Badge></TableCell>
                                        <TableCell><Badge variant="secondary">No</Badge></TableCell>
                                        <TableCell>Lucide icon component</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">onClick</TableCell>
                                        <TableCell><Badge variant="outline">(row) => void</Badge></TableCell>
                                        <TableCell><Badge variant="secondary">No</Badge></TableCell>
                                        <TableCell>Click handler function</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">href</TableCell>
                                        <TableCell><Badge variant="outline">(row) => string</Badge></TableCell>
                                        <TableCell><Badge variant="secondary">No</Badge></TableCell>
                                        <TableCell>Inertia navigation URL</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">show</TableCell>
                                        <TableCell><Badge variant="outline">(row) => boolean</Badge></TableCell>
                                        <TableCell><Badge variant="secondary">No</Badge></TableCell>
                                        <TableCell>Conditional visibility</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">destructive</TableCell>
                                        <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                                        <TableCell><Badge variant="secondary">No</Badge></TableCell>
                                        <TableCell>Apply destructive styling (red)</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">separator</TableCell>
                                        <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                                        <TableCell><Badge variant="secondary">No</Badge></TableCell>
                                        <TableCell>Render as separator line</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Image Column -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full">
                        <ChevronDown class="h-5 w-5" />
                        <span>imageColumn</span>
                        <Badge variant="secondary" class="ml-2">Image</Badge>
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Display images with automatic fallback, customizable size and shape. Perfect for avatars and thumbnails.
                        </p>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Usage Example</h4>
                            <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>import { imageColumn } from '@/common/components/dashboards/datatable/columnDef';

// Basic usage
imageColumn('avatar', 'Photo')

// With options
imageColumn('avatar', 'Photo', {
    fallback: '/images/default-avatar.png',
    size: 'lg',
    shape: 'circle',
    alt: (user) =&gt; user.name,
    sortable: false
})</code></pre>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Properties</h4>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Property</TableHead>
                                        <TableHead>Type</TableHead>
                                        <TableHead>Default</TableHead>
                                        <TableHead>Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">fallback</TableCell>
                                        <TableCell><Badge variant="outline">string</Badge></TableCell>
                                        <TableCell><code>'/images/default-avatar.png'</code></TableCell>
                                        <TableCell>Fallback image when value is null or fails to load</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">size</TableCell>
                                        <TableCell><Badge variant="outline">'sm' | 'md' | 'lg'</Badge></TableCell>
                                        <TableCell><code>'md'</code></TableCell>
                                        <TableCell>Image size (sm: 32px, md: 40px, lg: 64px)</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">shape</TableCell>
                                        <TableCell><Badge variant="outline">'circle' | 'square' | 'rounded'</Badge></TableCell>
                                        <TableCell><code>'circle'</code></TableCell>
                                        <TableCell>Image shape style</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">alt</TableCell>
                                        <TableCell><Badge variant="outline">(row) => string</Badge></TableCell>
                                        <TableCell><code>label</code></TableCell>
                                        <TableCell>Alt text function for accessibility</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Link Column -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full">
                        <ChevronDown class="h-5 w-5" />
                        <span>linkColumn</span>
                        <Badge variant="secondary" class="ml-2">Link</Badge>
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Display clickable links with optional external link icon. Auto-truncates long URLs for better display.
                        </p>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Usage Example</h4>
                            <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>import { linkColumn } from '@/common/components/dashboards/datatable/columnDef';

// Basic usage (uses value as href)
linkColumn('website', 'Website')

// With custom href
linkColumn('website', 'Website', {
    href: (value, row) =&gt; `https://${value}`,
    openInNewTab: true,
    showIcon: true
})

// External link
linkColumn('documentation_url', 'Docs', {
    openInNewTab: true,
    showIcon: true,
    className: 'font-medium'
})</code></pre>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2 text-sm">Properties</h4>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Property</TableHead>
                                        <TableHead>Type</TableHead>
                                        <TableHead>Default</TableHead>
                                        <TableHead>Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">href</TableCell>
                                        <TableCell><Badge variant="outline">(value, row) => string</Badge></TableCell>
                                        <TableCell><code>value</code></TableCell>
                                        <TableCell>Custom href function (defaults to cell value)</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">openInNewTab</TableCell>
                                        <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                                        <TableCell><code>false</code></TableCell>
                                        <TableCell>Open link in new tab (adds target="_blank")</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-xs">showIcon</TableCell>
                                        <TableCell><Badge variant="outline">boolean</Badge></TableCell>
                                        <TableCell><code>false</code></TableCell>
                                        <TableCell>Show external link icon (only when openInNewTab is true)</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>

                        <div class="border-l-4 border-blue-500 pl-4 bg-blue-500/5 p-3 rounded">
                            <h5 class="font-semibold text-sm mb-2">💡 Note</h5>
                            <p class="text-xs text-muted-foreground">
                                URLs longer than 40 characters are automatically truncated for display. The full URL is still used in the href attribute.
                            </p>
                        </div>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>

        <!-- Backend Integration -->
        <Card>
            <CardHeader>
                <CardTitle>🔧 Backend Integration (Laravel)</CardTitle>
            </CardHeader>
            <CardContent class="space-y-4">
                <div class="border-l-4 border-primary pl-4">
                    <h4 class="font-semibold mb-2">HasDataTable Trait</h4>
                    <p class="text-sm text-muted-foreground">
                        The <code>HasDataTable</code> trait in BaseController provides the <code>dataTable()</code> method for server-side processing.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold mb-2 text-sm">1. Service Layer Configuration</h4>
                    <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;?php

namespace App\Services\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserService
{
    public function getBaseQuery(): Builder
    {
        return User::select('id', 'name', 'email', 'is_active', 'created_at')
            -&gt;with('roles'); // Eager load relationships
    }

    public function getDataTableConfig(): array
    {
        return [
            'searchColumns' =&gt; ['name', 'email'],
            'allowedSorts' =&gt; ['name', 'email', 'created_at'],
            'allowedFilters' =&gt; [
                'role' =&gt; [
                    'type' =&gt; 'relationship',
                    'relationship' =&gt; 'roles',
                    'relation_column' =&gt; 'id',
                ],
                'status' =&gt; function ($query, $value) {
                    $query-&gt;where('is_active', $value === 'active' ? 1 : 0);
                },
                'created_from' =&gt; function ($query, $value) {
                    $query-&gt;whereDate('created_at', '&gt;=', $value);
                },
                'created_to' =&gt; function ($query, $value) {
                    $query-&gt;whereDate('created_at', '&lt;=', $value);
                },
            ],
        ];
    }
}</code></pre>
                </div>

                <div>
                    <h4 class="font-semibold mb-2 text-sm">2. Controller Implementation</h4>
                    <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Services\Core\UserService;

class UsersController extends BaseController
{
    public function __construct(
        private UserService $userService
    ) {}

    public function index()
    {
        $query = $this-&gt;userService-&gt;getBaseQuery();
        $config = $this-&gt;userService-&gt;getDataTableConfig();

        $users = $this-&gt;dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        return Inertia::render(SuperAdminPath::view("users/Index"), [
            'users' =&gt; $users,
            'filters' =&gt; $this-&gt;getFilters(['role', 'status', 'created_from', 'created_to']),
        ]);
    }
}</code></pre>
                </div>

                <div>
                    <h4 class="font-semibold mb-2 text-sm">3. Filter Types</h4>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Type</TableHead>
                                <TableHead>Example</TableHead>
                                <TableHead>Description</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow>
                                <TableCell class="font-mono text-xs">equals</TableCell>
                                <TableCell><code>['type' => 'equals', 'column' => 'status']</code></TableCell>
                                <TableCell>Exact match filter</TableCell>
                            </TableRow>
                            <TableRow>
                                <TableCell class="font-mono text-xs">like</TableCell>
                                <TableCell><code>['type' => 'like', 'column' => 'name']</code></TableCell>
                                <TableCell>LIKE search filter</TableCell>
                            </TableRow>
                            <TableRow>
                                <TableCell class="font-mono text-xs">relationship</TableCell>
                                <TableCell><code>['type' => 'relationship', 'relationship' => 'roles', 'relation_column' => 'id']</code></TableCell>
                                <TableCell>Filter by relationship</TableCell>
                            </TableRow>
                            <TableRow>
                                <TableCell class="font-mono text-xs">date_range</TableCell>
                                <TableCell><code>['type' => 'date_range', 'column' => 'created_at']</code></TableCell>
                                <TableCell>Date range filter (expects array [from, to])</TableCell>
                            </TableRow>
                            <TableRow>
                                <TableCell class="font-mono text-xs">boolean</TableCell>
                                <TableCell><code>['type' => 'boolean', 'column' => 'is_active']</code></TableCell>
                                <TableCell>Boolean filter</TableCell>
                            </TableRow>
                            <TableRow>
                                <TableCell class="font-mono text-xs">closure</TableCell>
                                <TableCell><code>function($query, $value) { ... }</code></TableCell>
                                <TableCell>Custom filter logic</TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </CardContent>
        </Card>

        <!-- Events -->
        <Card>
            <CardHeader>
                <CardTitle>📡 Events</CardTitle>
            </CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[200px]">Event</TableHead>
                            <TableHead class="w-[200px]">Payload</TableHead>
                            <TableHead>Description</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow>
                            <TableCell class="font-mono text-sm">@row-click</TableCell>
                            <TableCell><code>row: TData</code></TableCell>
                            <TableCell>Emitted when a row is clicked</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">@selection-change</TableCell>
                            <TableCell><code>rows: TData[]</code></TableCell>
                            <TableCell>Emitted when row selection changes</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">@update:filters</TableCell>
                            <TableCell><code>filters: any</code></TableCell>
                            <TableCell>Emitted when filters change (server-side only)</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>
        </Card>

        <!-- Slots -->
        <Card>
            <CardHeader>
                <CardTitle>🎨 Slots</CardTitle>
            </CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-[200px]">Slot</TableHead>
                            <TableHead class="w-[200px]">Bindings</TableHead>
                            <TableHead>Description</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow>
                            <TableCell class="font-mono text-sm">#toolbar</TableCell>
                            <TableCell><code>{ table }</code></TableCell>
                            <TableCell>Custom toolbar content (e.g., bulk action buttons)</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">#filters</TableCell>
                            <TableCell><code>{ table }</code></TableCell>
                            <TableCell>Custom filter panel content</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-mono text-sm">#empty</TableCell>
                            <TableCell>-</TableCell>
                            <TableCell>Custom empty state when no data</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>
        </Card>

        <!-- Complete Example -->
        <Card>
            <CardHeader>
                <CardTitle>🎯 Complete Example</CardTitle>
                <CardDescription>
                    Full implementation showing all features
                </CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
                <div>
                    <h4 class="font-semibold mb-2 text-sm">Column Definitions (userColumns.ts)</h4>
                    <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>import {
    createColumns,
    counterColumn,
    textColumn,
    badgeColumn,
    dateColumn,
    toggleColumn,
    actionsColumn,
    imageColumn,
    linkColumn
} from '@/common/components/dashboards/datatable/columnDef';
import { Copy, Eye, Edit, Trash2 } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';
import { useToast } from '@/core/composables/useToast';
import type { User } from './type';

/**
 * Factory function to create user table columns
 * @param openDeleteDialog - Function to open delete dialog (passed from parent)
 *
 * ⚠️ IMPORTANT: Must be a factory function that accepts openDeleteDialog as a parameter
 * This allows the delete dialog function to be properly passed from the parent component
 */
export function createUserColumns(openDeleteDialog: (user: User) =&gt; void) {
    const { showCopyToClipboardToast } = useToast();

    return createColumns&lt;User&gt;([
        counterColumn('#', { startFrom: 1 }),

        imageColumn('avatar_url', 'Avatar', {
            size: 'md',
            shape: 'circle',
            alt: (user) =&gt; user.name,
        }),

        textColumn('name', 'Name', {
            sortable: true,
            searchable: true,
            className: 'font-medium',
        }),

        textColumn('email', 'Email', {
            sortable: true,
            className: 'lowercase',
        }),

        badgeColumn('roles', 'Roles'),

        toggleColumn('is_active', 'Active', {
            onToggle: (value, user, control) =&gt; {
                router.patch(route('super-admin.users.toggle-status', user.id),
                    { is_active: value },
                    {
                        onSuccess: (page) =&gt; {
                            if (page.props.flash?.toast?.success === false) {
                                control.revert();
                            }
                        }
                    }
                );
            },
            size: 'sm',
        }),

        dateColumn('created_at', 'Joined', { relative: true }),

        actionsColumn([
            {
                label: 'Copy ID',
                icon: Copy,
                onClick: (user) =&gt; {
                    navigator.clipboard.writeText(user.id);
                    showCopyToClipboardToast('User ID');
                },
            },
            { separator: true, label: 'Separator' },
            {
                label: 'View',
                icon: Eye,
                href: (user) =&gt; route('super-admin.users.show', user.id),
            },
            {
                label: 'Edit',
                icon: Edit,
                href: (user) =&gt; route('super-admin.users.edit', user.id),
            },
            { separator: true, label: 'Separator' },
            {
                label: 'Delete',
                icon: Trash2,
                destructive: true,
                onClick: (user) =&gt; openDeleteDialog(user),
            },
        ]),
    ]);
}</code></pre>
                </div>

                <div>
                    <h4 class="font-semibold mb-2 text-sm">Type Definition (type.ts)</h4>
                    <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
    roles: Array&lt;{ name: string; id: number }&gt;;
    is_active?: boolean;
}</code></pre>
                </div>

                <div>
                    <h4 class="font-semibold mb-2 text-sm">Page Component (Index.vue)</h4>
                    <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;script setup lang="ts"&gt;
import DataTable from '@/common/components/dashboards/datatable/Datatable.vue';
import { createUserColumns } from './datatable/userColumns';
import type { User } from './datatable/type';
import { useFilters } from '@/core/composables/useFilters';
import { useDeleteDialog } from '@/modules/admin/composables/useDeleteDialog';

const props = defineProps&lt;{
    users: {
        data: User[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    filters: any;
}&gt;();

const tableConfig = {
    searchable: true,
    searchPlaceholder: 'Search users by name or email...',
    selectable: true,
    columnVisibility: true,
    perPageSelector: true,
    perPageOptions: [10, 25, 50, 100],
    serverSide: true,
    pagination: props.users,
    filterable: true,
    filters: props.filters,
    routeName: 'super-admin.users.index',
    preserveScroll: true,
};

const { localFilters, applyFilters, clearFilters } = useFilters(
    props.filters,
    { routeName: 'super-admin.users.index' }
);

// Setup delete dialog
const { deleteDialogOpen, itemToDelete, openDeleteDialog } = useDeleteDialog&lt;User&gt;();

// Create columns with delete dialog function passed as parameter
const userColumns = createUserColumns(openDeleteDialog);

const handleRowClick = (user: User) =&gt; {
    router.get(route('super-admin.users.show', user));
};
&lt;/script&gt;

&lt;template&gt;
    &lt;DataTable
        :columns="userColumns"
        :data="users.data"
        :config="tableConfig"
        @row-click="handleRowClick"
    &gt;
        &lt;template #toolbar="{ table }"&gt;
            &lt;Button
                v-if="table.getFilteredSelectedRowModel().rows.length &gt; 0"
                variant="destructive"
                size="sm"
            &gt;
                Delete ({ { table.getFilteredSelectedRowModel().rows.length } })
            &lt;/Button&gt;
        &lt;/template&gt;

        &lt;template #filters&gt;
            &lt;div class="grid grid-cols-1 gap-4 md:grid-cols-3"&gt;
                &lt;DashboardSelect
                    v-model="localFilters.role"
                    :options="roles"
                    optionLabel="name"
                    optionValue="id"
                    placeholder="All Roles"
                /&gt;
                &lt;DashboardDatePicker
                    v-model="localFilters.created_from"
                    placeholder="From Date"
                /&gt;
                &lt;DashboardDatePicker
                    v-model="localFilters.created_to"
                    placeholder="To Date"
                /&gt;
            &lt;/div&gt;

            &lt;div class="flex gap-2 mt-4"&gt;
                &lt;Button @click="applyFilters"&gt;Apply Filters&lt;/Button&gt;
                &lt;Button @click="clearFilters" variant="outline"&gt;Clear&lt;/Button&gt;
            &lt;/div&gt;
        &lt;/template&gt;
    &lt;/DataTable&gt;
&lt;/template&gt;</code></pre>
                </div>
            </CardContent>
        </Card>

        <!-- Recent Improvements -->
        <Card>
            <CardHeader>
                <CardTitle>🆕 Recent Improvements & Pattern Changes</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="space-y-4">
                    <div class="border-l-4 border-green-500 pl-4 bg-green-500/5 p-3 rounded">
                        <h4 class="font-semibold mb-2 text-sm">✨ New Column Types</h4>
                        <ul class="space-y-1 text-sm text-muted-foreground">
                            <li>• <code>imageColumn()</code> - Display images with fallback, customizable size & shape</li>
                            <li>• <code>linkColumn()</code> - Clickable links with auto-truncation and external link icons</li>
                            <li>• <code>customColumn()</code> - Custom render functions for advanced use cases</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-blue-500 pl-4 bg-blue-500/5 p-3 rounded">
                        <h4 class="font-semibold mb-2 text-sm">🔧 Badge Column Enhancement</h4>
                        <p class="text-sm text-muted-foreground mb-2">
                            <code>badgeColumn</code> now supports multiple badges from arrays (e.g., user roles):
                        </p>
                        <pre class="bg-muted p-2 rounded text-xs"><code>badgeColumn('roles', 'Roles', {
    multiple: true, // Automatically handles arrays
    variants: {
        'super-admin': 'destructive',
        'admin': 'default',
        'user': 'secondary'
    }
})</code></pre>
                    </div>

                    <div class="border-l-4 border-purple-500 pl-4 bg-purple-500/5 p-3 rounded">
                        <h4 class="font-semibold mb-2 text-sm">⚡ Factory Function Pattern (Breaking Change)</h4>
                        <p class="text-sm text-muted-foreground mb-2">
                            Column definitions must now be <strong>factory functions</strong> that accept dependencies as parameters:
                        </p>
                        <div class="bg-muted p-2 rounded text-xs space-y-2">
                            <div>
                                <div class="text-red-500 font-semibold mb-1">❌ Old Pattern (Don't use):</div>
                                <pre><code>// ❌ Module-level export with inject
export const userColumns = createColumns([...]);
const { openDeleteDialog } = useDeleteDialogTrigger();</code></pre>
                            </div>
                            <div>
                                <div class="text-green-500 font-semibold mb-1">✅ New Pattern (Use this):</div>
                                <pre><code>// ✅ Factory function with parameters
export function createUserColumns(openDeleteDialog: (user: User) =&gt; void) {
    return createColumns([...]);
}</code></pre>
                            </div>
                        </div>
                        <p class="text-xs text-muted-foreground mt-2">
                            <strong>Why?</strong> Prevents timing issues with Vue's provide/inject in &lt;script setup&gt; and makes dependencies explicit.
                        </p>
                    </div>

                    <div class="border-l-4 border-orange-500 pl-4 bg-orange-500/5 p-3 rounded">
                        <h4 class="font-semibold mb-2 text-sm">🎯 Simplified Delete Dialog Pattern</h4>
                        <p class="text-sm text-muted-foreground mb-2">
                            No more global window hacks or provide/inject complexity:
                        </p>
                        <pre class="bg-muted p-2 rounded text-xs"><code>// In Index.vue
const { deleteDialogOpen, itemToDelete, openDeleteDialog } = useDeleteDialog&lt;User&gt;();
const userColumns = createUserColumns(openDeleteDialog); // Pass it directly!

// In column definition
onClick: (user) =&gt; openDeleteDialog(user) // Clean & type-safe!</code></pre>
                    </div>
                </div>
            </CardContent>
        </Card>

        <!-- Best Practices -->
        <Card>
            <CardHeader>
                <CardTitle>✅ Best Practices</CardTitle>
            </CardHeader>
            <CardContent>
                <div class="space-y-4">
                    <div class="border-l-4 border-green-500 pl-4">
                        <h4 class="font-semibold mb-2 text-sm">Performance</h4>
                        <ul class="space-y-1 text-sm text-muted-foreground">
                            <li>• Use <code>select()</code> in base queries to only load needed columns</li>
                            <li>• Eager load relationships with <code>with()</code> to prevent N+1 queries</li>
                            <li>• Enable server-side pagination for large datasets (>1000 rows)</li>
                            <li>• Use debouncing for search (300ms default)</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="font-semibold mb-2 text-sm">Organization</h4>
                        <ul class="space-y-1 text-sm text-muted-foreground">
                            <li>• Keep column definitions in separate <code>datatable/</code> folder</li>
                            <li>• Define TypeScript interfaces for row data</li>
                            <li>• Use service layer for DataTable configuration</li>
                            <li>• Extract reusable filters into composables</li>
                            <li>• ⚠️ <strong>Use factory functions</strong> for column definitions (export function, not const)</li>
                            <li>• ⚠️ <strong>Pass functions as parameters</strong> instead of using provide/inject in column files</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-yellow-500 pl-4">
                        <h4 class="font-semibold mb-2 text-sm">Security</h4>
                        <ul class="space-y-1 text-sm text-muted-foreground">
                            <li>• Whitelist sortable columns in <code>allowedSorts</code></li>
                            <li>• Whitelist searchable columns in <code>searchColumns</code></li>
                            <li>• Validate filter values on backend</li>
                            <li>• Use middleware for permission checks on actions</li>
                        </ul>
                    </div>

                    <div class="border-l-4 border-purple-500 pl-4">
                        <h4 class="font-semibold mb-2 text-sm">UX</h4>
                        <ul class="space-y-1 text-sm text-muted-foreground">
                            <li>• Provide meaningful search placeholders</li>
                            <li>• Show loading states during toggle actions</li>
                            <li>• Use <code>preserveScroll: true</code> for better UX</li>
                            <li>• Display empty states when no results</li>
                            <li>• Use relative dates for recent timestamps</li>
                        </ul>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
