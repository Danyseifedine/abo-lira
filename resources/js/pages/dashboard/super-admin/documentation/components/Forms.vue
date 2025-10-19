<script setup lang="ts">
import DashboardButton from '@common/components/dashboards/form/DashboardButton.vue';
import DashboardCheckbox from '@common/components/dashboards/form/DashboardCheckbox.vue';
import DashboardDatePicker from '@common/components/dashboards/form/DashboardDatePicker.vue';
import DashboardFileUpload from '@common/components/dashboards/form/DashboardFileUpload.vue';
import DashboardMaskedInput from '@common/components/dashboards/form/DashboardMaskedInput.vue';
import DashboardMultiSelect from '@common/components/dashboards/form/DashboardMultiSelect.vue';
import DashboardRadioButton from '@common/components/dashboards/form/DashboardRadioButton.vue';
import DashboardSelect from '@common/components/dashboards/form/DashboardSelect.vue';
import DashboardTextInput from '@common/components/dashboards/form/DashboardTextInput.vue';
import DashboardToggle from '@common/components/dashboards/form/DashboardToggle.vue';
import Hint from '@common/components/dashboards/typography/Hint.vue';
import { Badge } from '@ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@ui/card';
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@ui/collapsible';
import { Label } from '@ui/label';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@ui/table';
import { ChevronDown, Eye } from 'lucide-vue-next';
import { ref } from 'vue';

const activeComponent = ref<string | null>('DashboardTextInput');

// Demo form state
const demoForm = ref({
    text: '',
    email: '',
    password: '',
    role: null,
    roles: [] as number[],
    date: null as Date | null,
    dateRange: null as Date[] | null,
    dateTime: null as Date | null,
    files: [] as File[],
    checkbox: false,
    checkboxArray: [] as string[],
    toggle: false,
    radio: null as string | null,
    errors: {} as Record<string, string>,
});

const demoRoles = [
    { id: 1, name: 'Admin' },
    { id: 2, name: 'Editor' },
    { id: 3, name: 'Viewer' },
];

const components = [
    { id: 'DashboardTextInput', name: 'Text Input', color: 'default' },
    { id: 'DashboardMaskedInput', name: 'Password Input', color: 'secondary' },
    { id: 'DashboardSelect', name: 'Select', color: 'outline' },
    { id: 'DashboardMultiSelect', name: 'Multi Select', color: 'outline' },
    { id: 'DashboardDatePicker', name: 'Date Picker', color: 'outline' },
    { id: 'DashboardFileUpload', name: 'File Upload', color: 'outline' },
    { id: 'DashboardCheckbox', name: 'Checkbox', color: 'outline' },
    { id: 'DashboardToggle', name: 'Toggle Switch', color: 'outline' },
    { id: 'DashboardRadioButton', name: 'Radio Button', color: 'outline' },
    { id: 'DashboardButton', name: 'Button', color: 'default' },
];

const selectComponent = (id: string) => {
    activeComponent.value = activeComponent.value === id ? null : id;
};
</script>

<template>
    <div class="space-y-6">
        <!-- Component Navigation -->
        <Card>
            <CardHeader>
                <CardTitle>Form Components</CardTitle>
                <CardDescription>Click a component below to view its documentation and live preview</CardDescription>
            </CardHeader>
            <CardContent>
                <div class="flex flex-wrap gap-3">
                    <Badge
                        v-for="component in components"
                        :key="component.id"
                        :variant="activeComponent === component.id ? 'default' : 'outline'"
                        class="cursor-pointer px-4 py-2 text-sm transition-colors hover:bg-primary/10"
                        @click="selectComponent(component.id)"
                    >
                        {{ component.name }}
                    </Badge>
                </div>
            </CardContent>
        </Card>

        <!-- ==================== DashboardTextInput ==================== -->
        <Card v-if="activeComponent === 'DashboardTextInput'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">DashboardTextInput</CardTitle>
                        <CardDescription class="mt-2 text-base"> Text input with automatic error handling and consistent defaults </CardDescription>
                    </div>
                    <Badge variant="secondary">Form Input</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="rounded-lg border-2 border-dashed bg-muted/30 p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <Eye class="h-5 w-5 text-primary" />
                        <h3 class="text-lg font-bold">Live Preview</h3>
                    </div>
                    <div class="space-y-6 rounded-lg bg-background p-6">
                        <div>
                            <Label for="demo-text">Text Input</Label>
                            <DashboardTextInput id="demo-text" v-model="demoForm.text" placeholder="Type something..." class="mt-2" />
                            <Hint text="This is a standard text input" class="mt-1" />
                        </div>
                        <div>
                            <Label for="demo-email" required>Email with Error</Label>
                            <DashboardTextInput
                                id="demo-email"
                                v-model="demoForm.email"
                                type="email"
                                placeholder="your@email.com"
                                error="This email is already taken"
                                class="mt-2"
                            />
                            <Hint text="This email is already taken" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Import -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">📦 Import</h3>
                    <pre
                        class="rounded-lg bg-muted p-4 text-sm"
                    ><code>import DashboardTextInput from '@common/components/dashboards/form/DashboardTextInput.vue';</code></pre>
                </div>

                <!-- Props Table -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">⚙️ Props</h3>
                    <div class="overflow-hidden rounded-lg border">
                        <Table>
                            <TableHeader>
                                <TableRow class="bg-muted/50">
                                    <TableHead class="font-bold">Prop</TableHead>
                                    <TableHead class="font-bold">Type</TableHead>
                                    <TableHead class="font-bold">Default</TableHead>
                                    <TableHead class="font-bold">Description</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">modelValue</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string | number | null</Badge>
                                    </TableCell>
                                    <TableCell><code>''</code></TableCell>
                                    <TableCell>The v-model binding value</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">type</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'text'</code></TableCell>
                                    <TableCell> Input type: 'text' | 'email' | 'password' | 'number' | 'tel' | 'url' </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">placeholder</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell>-</TableCell>
                                    <TableCell>Placeholder text</TableCell>
                                </TableRow>
                                <TableRow class="bg-destructive/5">
                                    <TableCell class="font-mono text-sm font-bold">error</TableCell>
                                    <TableCell>
                                        <Badge variant="destructive">string | null</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>
                                        <strong>⚠️ Automatically shows red border when provided</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">disabled</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Disables the input</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">required</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>HTML required attribute</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">size</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'small'</code></TableCell>
                                    <TableCell>'small' | 'large'</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">fluid</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Makes input full width (100%)</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">autofocus</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Auto-focus on mount</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">id</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell>-</TableCell>
                                    <TableCell>HTML id for label association</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">class</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell>-</TableCell>
                                    <TableCell>Additional CSS classes</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Events -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        🎯 Events
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="overflow-hidden rounded-lg border">
                            <Table>
                                <TableHeader>
                                    <TableRow class="bg-muted/50">
                                        <TableHead class="font-bold">Event</TableHead>
                                        <TableHead class="font-bold">Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">@update:modelValue</TableCell>
                                        <TableCell>Emitted when value changes (v-model)</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">@blur</TableCell>
                                        <TableCell>Emitted when input loses focus</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">@focus</TableCell>
                                        <TableCell>Emitted when input gains focus</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Usage Example -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Example
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <pre class="overflow-x-auto rounded-lg bg-muted p-4 text-sm"><code>&lt;template&gt;
    &lt;div&gt;
        &lt;Label for="email" required&gt;Email Address&lt;/Label&gt;
        &lt;DashboardTextInput
            id="email"
            v-model="form.email"
            type="email"
            placeholder="your@email.com"
            :error="form.errors.email"
            required
        /&gt;
        &lt;Hint v-if="form.errors.email" :text="form.errors.email" /&gt;
    &lt;/div&gt;
&lt;/template&gt;

&lt;script setup lang="ts"&gt;
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
});
&lt;/script&gt;</code></pre>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>

        <!-- ==================== DashboardMaskedInput ==================== -->
        <Card v-if="activeComponent === 'DashboardMaskedInput'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">DashboardMaskedInput</CardTitle>
                        <CardDescription class="mt-2 text-base"> Password input with toggle visibility and strength meter </CardDescription>
                    </div>
                    <Badge variant="secondary">Password Input</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="rounded-lg border-2 border-dashed bg-muted/30 p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <Eye class="h-5 w-5 text-primary" />
                        <h3 class="text-lg font-bold">Live Preview</h3>
                    </div>
                    <div class="space-y-6 rounded-lg bg-background p-6">
                        <div>
                            <Label for="demo-password">Password with Toggle</Label>
                            <DashboardMaskedInput
                                id="demo-password"
                                v-model="demoForm.password"
                                placeholder="Enter password"
                                toggle-mask
                                class="mt-2"
                            />
                            <Hint text="Click the eye icon to show/hide password" class="mt-1" />
                        </div>
                        <div>
                            <Label for="demo-password-strength">Password with Strength Meter</Label>
                            <DashboardMaskedInput
                                id="demo-password-strength"
                                v-model="demoForm.password"
                                placeholder="Enter password"
                                toggle-mask
                                show-strength
                                class="mt-2"
                            />
                            <Hint text="Strength meter shows weak/medium/strong" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Import -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">📦 Import</h3>
                    <pre
                        class="rounded-lg bg-muted p-4 text-sm"
                    ><code>import DashboardMaskedInput from '@common/components/dashboards/form/DashboardMaskedInput.vue';</code></pre>
                </div>

                <!-- Props Table -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">⚙️ Props</h3>
                    <div class="overflow-hidden rounded-lg border">
                        <Table>
                            <TableHeader>
                                <TableRow class="bg-muted/50">
                                    <TableHead class="font-bold">Prop</TableHead>
                                    <TableHead class="font-bold">Type</TableHead>
                                    <TableHead class="font-bold">Default</TableHead>
                                    <TableHead class="font-bold">Description</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">modelValue</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string | null</Badge>
                                    </TableCell>
                                    <TableCell><code>''</code></TableCell>
                                    <TableCell>The v-model binding value</TableCell>
                                </TableRow>
                                <TableRow class="bg-blue-500/5">
                                    <TableCell class="font-mono text-sm font-bold">toggleMask</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>
                                        <strong>👁️ Shows/hides password toggle button (eye icon)</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-blue-500/5">
                                    <TableCell class="font-mono text-sm font-bold">showStrength</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>
                                        <strong>💪 Shows password strength meter below input</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">placeholder</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell>-</TableCell>
                                    <TableCell>Placeholder text</TableCell>
                                </TableRow>
                                <TableRow class="bg-destructive/5">
                                    <TableCell class="font-mono text-sm font-bold">error</TableCell>
                                    <TableCell>
                                        <Badge variant="destructive">string | null</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>
                                        <strong>⚠️ Automatically shows red border when provided</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm" colspan="4">
                                        <em class="text-muted-foreground">
                                            + All props from DashboardTextInput (disabled, required, size, fluid, etc.)
                                        </em>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Usage Example -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Example
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <pre class="overflow-x-auto rounded-lg bg-muted p-4 text-sm"><code>&lt;template&gt;
    &lt;div&gt;
        &lt;Label for="password" required&gt;Password&lt;/Label&gt;
        &lt;DashboardMaskedInput
            id="password"
            v-model="form.password"
            placeholder="Enter strong password"
            :error="form.errors.password"
            toggle-mask
            show-strength
            required
        /&gt;
        &lt;Hint v-if="form.errors.password" :text="form.errors.password" /&gt;
    &lt;/div&gt;
&lt;/template&gt;</code></pre>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>

        <!-- ==================== DashboardSelect ==================== -->
        <Card v-if="activeComponent === 'DashboardSelect'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">DashboardSelect</CardTitle>
                        <CardDescription class="mt-2 text-base"> Single-value select with search/filter and error handling </CardDescription>
                    </div>
                    <Badge variant="secondary">Dropdown</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="rounded-lg border-2 border-dashed bg-muted/30 p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <Eye class="h-5 w-5 text-primary" />
                        <h3 class="text-lg font-bold">Live Preview</h3>
                    </div>
                    <div class="space-y-6 rounded-lg bg-background p-6">
                        <div>
                            <Label for="demo-role">Select with Filter</Label>
                            <DashboardSelect
                                id="demo-role"
                                v-model="demoForm.role"
                                :options="demoRoles"
                                option-label="name"
                                option-value="id"
                                placeholder="Select a role"
                                filter
                                class="mt-2"
                            />
                            <Hint text="Try typing to filter options" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Import -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">📦 Import</h3>
                    <pre
                        class="rounded-lg bg-muted p-4 text-sm"
                    ><code>import DashboardSelect from '@common/components/dashboards/form/DashboardSelect.vue';</code></pre>
                </div>

                <!-- Props Table -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">⚙️ Props</h3>
                    <div class="overflow-hidden rounded-lg border">
                        <Table>
                            <TableHeader>
                                <TableRow class="bg-muted/50">
                                    <TableHead class="font-bold">Prop</TableHead>
                                    <TableHead class="font-bold">Type</TableHead>
                                    <TableHead class="font-bold">Default</TableHead>
                                    <TableHead class="font-bold">Description</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">modelValue</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string | number | boolean | null</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>The v-model binding value</TableCell>
                                </TableRow>
                                <TableRow class="bg-yellow-500/10">
                                    <TableCell class="font-mono text-sm font-bold">options</TableCell>
                                    <TableCell>
                                        <Badge variant="default">any[]</Badge>
                                    </TableCell>
                                    <TableCell>-</TableCell>
                                    <TableCell>
                                        <strong>⚠️ REQUIRED: Array of options to display</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-blue-500/5">
                                    <TableCell class="font-mono text-sm font-bold">optionLabel</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'name'</code></TableCell>
                                    <TableCell>
                                        <strong>Property name for display label (e.g., 'name', 'title')</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-blue-500/5">
                                    <TableCell class="font-mono text-sm font-bold">optionValue</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'code'</code></TableCell>
                                    <TableCell>
                                        <strong>Property name for value (e.g., 'id', 'code')</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">placeholder</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'Select an option'</code></TableCell>
                                    <TableCell>Placeholder text</TableCell>
                                </TableRow>
                                <TableRow class="bg-destructive/5">
                                    <TableCell class="font-mono text-sm font-bold">error</TableCell>
                                    <TableCell>
                                        <Badge variant="destructive">string | null</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>
                                        <strong>⚠️ Automatically shows red border when provided</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">showClear</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Shows clear button (X icon)</TableCell>
                                </TableRow>
                                <TableRow class="bg-green-500/5">
                                    <TableCell class="font-mono text-sm font-bold">filter</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>
                                        <strong>🔍 Enables search/filter functionality</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">filterPlaceholder</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'Search...'</code></TableCell>
                                    <TableCell>Filter input placeholder</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">scrollHeight</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'200px'</code></TableCell>
                                    <TableCell>Max height of dropdown</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm" colspan="4">
                                        <em class="text-muted-foreground">
                                            + All props from DashboardTextInput (disabled, size, fluid, id, class, etc.)
                                        </em>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Usage Example -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Example
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <pre class="overflow-x-auto rounded-lg bg-muted p-4 text-sm"><code>&lt;template&gt;
    &lt;div&gt;
        &lt;Label for="role" required&gt;Role&lt;/Label&gt;
        &lt;DashboardSelect
            id="role"
            v-model="form.role_id"
            :options="roles"
            option-label="name"
            option-value="id"
            placeholder="Select a role"
            :error="form.errors.role_id"
            filter
            required
        /&gt;
        &lt;Hint v-if="form.errors.role_id" :text="form.errors.role_id" /&gt;
    &lt;/div&gt;
&lt;/template&gt;

&lt;script setup lang="ts"&gt;
const roles = [
    { id: 1, name: 'Admin' },
    { id: 2, name: 'Editor' },
    { id: 3, name: 'Viewer' },
];
&lt;/script&gt;</code></pre>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>

        <!-- ==================== DashboardMultiSelect ==================== -->
        <Card v-if="activeComponent === 'DashboardMultiSelect'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">DashboardMultiSelect</CardTitle>
                        <CardDescription class="mt-2 text-base"> Multi-select dropdown with chip display and filtering support </CardDescription>
                    </div>
                    <Badge variant="secondary">Dropdown</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="rounded-lg border-2 border-dashed bg-muted/30 p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <Eye class="h-5 w-5 text-primary" />
                        <h3 class="text-lg font-bold">Live Preview</h3>
                    </div>
                    <div class="space-y-6 rounded-lg bg-background p-6">
                        <div>
                            <Label for="demo-multiselect">Multi Select</Label>
                            <DashboardMultiSelect
                                id="demo-multiselect"
                                v-model="demoForm.roles"
                                :options="[
                                    { id: 1, name: 'Admin' },
                                    { id: 2, name: 'Editor' },
                                    { id: 3, name: 'Viewer' },
                                    { id: 4, name: 'Manager' },
                                ]"
                                option-label="name"
                                option-value="id"
                                placeholder="Select roles"
                                filter
                                filter-placeholder="Search roles..."
                                display="chip"
                                :show-toggle-all="false"
                                :max-selected-labels="5"
                                selected-items-label="{0} roles selected"
                                class="mt-2"
                            />
                            <Hint text="Select one or more roles" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Import -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">📦 Import</h3>
                    <pre
                        class="rounded-lg bg-muted p-4 text-sm"
                    ><code>import DashboardMultiSelect from '@common/components/dashboards/form/DashboardMultiSelect.vue';</code></pre>
                </div>

                <!-- Props Table -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">⚙️ Props</h3>
                    <div class="overflow-hidden rounded-lg border">
                        <Table>
                            <TableHeader>
                                <TableRow class="bg-muted/50">
                                    <TableHead class="font-bold">Prop</TableHead>
                                    <TableHead class="font-bold">Type</TableHead>
                                    <TableHead class="font-bold">Default</TableHead>
                                    <TableHead class="font-bold">Description</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow class="bg-primary/5">
                                    <TableCell class="font-mono text-sm font-bold">modelValue</TableCell>
                                    <TableCell>
                                        <Badge variant="default">any[] | null</Badge>
                                    </TableCell>
                                    <TableCell><code>[]</code></TableCell>
                                    <TableCell>
                                        <strong>✅ Selected values (v-model binding)</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-yellow-500/10">
                                    <TableCell class="font-mono text-sm font-bold">options</TableCell>
                                    <TableCell>
                                        <Badge variant="default">any[]</Badge>
                                    </TableCell>
                                    <TableCell><code>required</code></TableCell>
                                    <TableCell>
                                        <strong>⚠️ REQUIRED: Array of options to select from</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-blue-500/5">
                                    <TableCell class="font-mono text-sm font-bold">optionLabel</TableCell>
                                    <TableCell>
                                        <Badge variant="default">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'label'</code></TableCell>
                                    <TableCell>
                                        <strong>Property name to use as the display label</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-blue-500/5">
                                    <TableCell class="font-mono text-sm font-bold">optionValue</TableCell>
                                    <TableCell>
                                        <Badge variant="default">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'value'</code></TableCell>
                                    <TableCell>
                                        <strong>Property name to use as the value</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-destructive/5">
                                    <TableCell class="font-mono text-sm font-bold">error</TableCell>
                                    <TableCell>
                                        <Badge variant="destructive">string | null</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>
                                        <strong>⚠️ Automatically shows red border when provided</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-green-500/5">
                                    <TableCell class="font-mono text-sm font-bold">filter</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>
                                        <strong>🔍 Enable filtering/search in dropdown</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">filterPlaceholder</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'Search...'</code></TableCell>
                                    <TableCell>Filter input placeholder text</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">display</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">'comma' | 'chip'</Badge>
                                    </TableCell>
                                    <TableCell><code>'chip'</code></TableCell>
                                    <TableCell>Display mode for selected items</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">showClear</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Show clear button</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">showToggleAll</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Show toggle all checkbox</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">maxSelectedLabels</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">number</Badge>
                                    </TableCell>
                                    <TableCell><code>3</code></TableCell>
                                    <TableCell>Max number of selected labels to show</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">selectedItemsLabel</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'{0} items selected'</code></TableCell>
                                    <TableCell>Text when more items selected than maxSelectedLabels</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">placeholder</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'Select items'</code></TableCell>
                                    <TableCell>Placeholder text</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">disabled</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Disabled state</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">size</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">'small' | 'large'</Badge>
                                    </TableCell>
                                    <TableCell><code>'small'</code></TableCell>
                                    <TableCell>Size variant</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">fluid</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Full width</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">scrollHeight</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'200px'</code></TableCell>
                                    <TableCell>Scroll height for dropdown</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">optionGroupLabel</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Property name for option group label</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">optionGroupChildren</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Property name for option group children</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">id</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Input id attribute</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">class</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>''</code></TableCell>
                                    <TableCell>Additional CSS classes</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Events -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        🎯 Events
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="overflow-hidden rounded-lg border">
                            <Table>
                                <TableHeader>
                                    <TableRow class="bg-muted/50">
                                        <TableHead class="font-bold">Event</TableHead>
                                        <TableHead class="font-bold">Payload</TableHead>
                                        <TableHead class="font-bold">Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">update:modelValue</TableCell>
                                        <TableCell>
                                            <Badge>any[]</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when value changes (v-model)</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">change</TableCell>
                                        <TableCell>
                                            <Badge>event</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when selection changes</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">blur</TableCell>
                                        <TableCell>
                                            <Badge>Event</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when input loses focus</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">focus</TableCell>
                                        <TableCell>
                                            <Badge>Event</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when input gains focus</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Usage Example -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Example
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <pre class="overflow-x-auto rounded-lg bg-muted p-4 text-sm"><code>&lt;template&gt;
    &lt;div class="space-y-2"&gt;
        &lt;Label for="roles" required&gt;Roles&lt;/Label&gt;
        &lt;DashboardMultiSelect
            id="roles"
            v-model="form.roles"
            :options="roles"
            option-label="name"
            option-value="id"
            placeholder="Select roles"
            :error="form.errors.roles"
            filter
            filter-placeholder="Search roles..."
            display="chip"
            :show-toggle-all="false"
            :max-selected-labels="5"
            selected-items-label="{0} roles selected"
        /&gt;
        &lt;InputError :message="form.errors.roles" /&gt;
        &lt;Hint text="Assign one or more roles to this user." /&gt;
    &lt;/div&gt;
&lt;/template&gt;

&lt;script setup lang="ts"&gt;
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    roles: [] as number[],
});

const roles = [
    { id: 1, name: 'Admin' },
    { id: 2, name: 'Editor' },
    { id: 3, name: 'Viewer' },
    { id: 4, name: 'Manager' },
];
&lt;/script&gt;</code></pre>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>

        <!-- ==================== DashboardDatePicker ==================== -->
        <Card v-if="activeComponent === 'DashboardDatePicker'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">DashboardDatePicker</CardTitle>
                        <CardDescription class="mt-2 text-base">
                            Versatile date/time picker with calendar, range selection, and time support
                        </CardDescription>
                    </div>
                    <Badge variant="secondary">Date Input</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="rounded-lg border-2 border-dashed bg-muted/30 p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <Eye class="h-5 w-5 text-primary" />
                        <h3 class="text-lg font-bold">Live Preview</h3>
                    </div>
                    <div class="space-y-6 rounded-lg bg-background p-6">
                        <div>
                            <Label for="demo-date">Single Date</Label>
                            <DashboardDatePicker id="demo-date" v-model="demoForm.date" placeholder="Select a date" show-icon class="mt-2" />
                            <Hint text="Basic date picker" class="mt-1" />
                        </div>
                        <div>
                            <Label for="demo-date-range">Date Range</Label>
                            <DashboardDatePicker
                                id="demo-date-range"
                                v-model="demoForm.dateRange"
                                selection-mode="range"
                                placeholder="Select date range"
                                show-icon
                                class="mt-2"
                            />
                            <Hint text="Select start and end date" class="mt-1" />
                        </div>
                        <div>
                            <Label for="demo-datetime">Date & Time</Label>
                            <DashboardDatePicker
                                id="demo-datetime"
                                v-model="demoForm.dateTime"
                                show-time
                                placeholder="Select date and time"
                                show-icon
                                class="mt-2"
                            />
                            <Hint text="Date picker with time selection" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Import -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">📦 Import</h3>
                    <pre
                        class="rounded-lg bg-muted p-4 text-sm"
                    ><code>import DashboardDatePicker from '@common/components/dashboards/form/DashboardDatePicker.vue';</code></pre>
                </div>

                <!-- Props Table -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">⚙️ Props</h3>
                    <div class="overflow-hidden rounded-lg border">
                        <Table>
                            <TableHeader>
                                <TableRow class="bg-muted/50">
                                    <TableHead class="font-bold">Prop</TableHead>
                                    <TableHead class="font-bold">Type</TableHead>
                                    <TableHead class="font-bold">Default</TableHead>
                                    <TableHead class="font-bold">Description</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow class="bg-primary/5">
                                    <TableCell class="font-mono text-sm font-bold">modelValue</TableCell>
                                    <TableCell>
                                        <Badge variant="default">Date | Date[] | null</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>
                                        <strong>✅ Selected date(s) (v-model binding)</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-blue-500/5">
                                    <TableCell class="font-mono text-sm font-bold">selectionMode</TableCell>
                                    <TableCell>
                                        <Badge variant="default">'single' | 'multiple' | 'range'</Badge>
                                    </TableCell>
                                    <TableCell><code>'single'</code></TableCell>
                                    <TableCell>
                                        <strong>📅 Selection mode: single date, multiple dates, or date range</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-blue-500/5">
                                    <TableCell class="font-mono text-sm font-bold">view</TableCell>
                                    <TableCell>
                                        <Badge variant="default">'date' | 'month' | 'year'</Badge>
                                    </TableCell>
                                    <TableCell><code>'date'</code></TableCell>
                                    <TableCell>
                                        <strong>📆 View mode: calendar with days, months only, or years only</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-green-500/5">
                                    <TableCell class="font-mono text-sm font-bold">showTime</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>
                                        <strong>🕐 Enable time picker alongside date</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-green-500/5">
                                    <TableCell class="font-mono text-sm font-bold">timeOnly</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>
                                        <strong>⏰ Show only time picker (no date selection)</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">dateFormat</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'yy-mm-dd'</code></TableCell>
                                    <TableCell>Date format pattern (e.g., 'dd/mm/yy', 'mm/dd/yy')</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">hourFormat</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">'12' | '24'</Badge>
                                    </TableCell>
                                    <TableCell><code>'24'</code></TableCell>
                                    <TableCell>Hour format for time picker</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">showSeconds</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Show seconds in time picker</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">showIcon</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Show calendar icon</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">iconDisplay</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">'button' | 'input'</Badge>
                                    </TableCell>
                                    <TableCell><code>'button'</code></TableCell>
                                    <TableCell>Icon position: button on right or inside input on left</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">placeholder</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'Select date'</code></TableCell>
                                    <TableCell>Placeholder text</TableCell>
                                </TableRow>
                                <TableRow class="bg-destructive/5">
                                    <TableCell class="font-mono text-sm font-bold">error</TableCell>
                                    <TableCell>
                                        <Badge variant="destructive">string | null</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>
                                        <strong>⚠️ Automatically shows red border when provided</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">minDate</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">Date</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Minimum selectable date</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">maxDate</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">Date</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Maximum selectable date</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">disabledDates</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">Date[]</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Array of dates to disable</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">disabledDays</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">number[]</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Disabled days of week (0-6, Sunday-Saturday)</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">showWeek</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Show week numbers</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">numberOfMonths</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">number</Badge>
                                    </TableCell>
                                    <TableCell><code>1</code></TableCell>
                                    <TableCell>Number of months to display</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">inline</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Inline display mode (no input, just calendar)</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">showClear</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Show clear button</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm" colspan="4">
                                        <em class="text-muted-foreground"> + Common props: disabled, required, size, fluid, id, class </em>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Events -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        🎯 Events
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="overflow-hidden rounded-lg border">
                            <Table>
                                <TableHeader>
                                    <TableRow class="bg-muted/50">
                                        <TableHead class="font-bold">Event</TableHead>
                                        <TableHead class="font-bold">Payload</TableHead>
                                        <TableHead class="font-bold">Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">update:modelValue</TableCell>
                                        <TableCell>
                                            <Badge>Date | Date[] | null</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when value changes (v-model)</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">change</TableCell>
                                        <TableCell>
                                            <Badge>Date | Date[] | null</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when date changes</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">select</TableCell>
                                        <TableCell>
                                            <Badge>Date | Date[]</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when date is selected</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">blur</TableCell>
                                        <TableCell>
                                            <Badge>Event</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when input loses focus</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">focus</TableCell>
                                        <TableCell>
                                            <Badge>Event</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when input gains focus</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">month-change</TableCell>
                                        <TableCell>
                                            <Badge>Event</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when month changes</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">year-change</TableCell>
                                        <TableCell>
                                            <Badge>Event</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when year changes</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Usage Examples -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Examples
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="space-y-4">
                            <div>
                                <h4 class="mb-2 text-sm font-semibold">1. Basic Date Picker</h4>
                                <pre
                                    class="overflow-x-auto rounded bg-muted p-3 text-sm"
                                ><code>&lt;Label for="birth_date" required&gt;Birth Date&lt;/Label&gt;
&lt;DashboardDatePicker
    id="birth_date"
    v-model="form.birth_date"
    placeholder="Select your birth date"
    :error="form.errors.birth_date"
    show-icon
/&gt;
&lt;InputError :message="form.errors.birth_date" /&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="mb-2 text-sm font-semibold">2. Date Range Picker</h4>
                                <pre class="overflow-x-auto rounded bg-muted p-3 text-sm"><code>&lt;Label for="date_range"&gt;Date Range&lt;/Label&gt;
&lt;DashboardDatePicker
    id="date_range"
    v-model="form.date_range"
    selection-mode="range"
    placeholder="Select start and end date"
    show-icon
/&gt;
&lt;Hint text="Select a start and end date for the report" /&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="mb-2 text-sm font-semibold">3. Date & Time Picker</h4>
                                <pre
                                    class="overflow-x-auto rounded bg-muted p-3 text-sm"
                                ><code>&lt;Label for="scheduled_at"&gt;Schedule For&lt;/Label&gt;
&lt;DashboardDatePicker
    id="scheduled_at"
    v-model="form.scheduled_at"
    show-time
    hour-format="12"
    placeholder="Select date and time"
    show-icon
    date-format="mm/dd/yy"
/&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="mb-2 text-sm font-semibold">4. Month Picker</h4>
                                <pre class="overflow-x-auto rounded bg-muted p-3 text-sm"><code>&lt;Label for="month"&gt;Select Month&lt;/Label&gt;
&lt;DashboardDatePicker
    id="month"
    v-model="form.month"
    view="month"
    date-format="mm/yy"
    placeholder="Select month"
    show-icon
/&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="mb-2 text-sm font-semibold">5. Time Only Picker</h4>
                                <pre class="overflow-x-auto rounded bg-muted p-3 text-sm"><code>&lt;Label for="time"&gt;Select Time&lt;/Label&gt;
&lt;DashboardDatePicker
    id="time"
    v-model="form.time"
    time-only
    hour-format="12"
    show-seconds
    placeholder="Select time"
/&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="mb-2 text-sm font-semibold">6. With Date Restrictions</h4>
                                <pre
                                    class="overflow-x-auto rounded bg-muted p-3 text-sm"
                                ><code>&lt;Label for="appointment"&gt;Appointment Date&lt;/Label&gt;
&lt;DashboardDatePicker
    id="appointment"
    v-model="form.appointment_date"
    :min-date="new Date()"
    :max-date="maxDate"
    :disabled-days="[0, 6]"
    placeholder="Select appointment date"
    show-icon
/&gt;
&lt;Hint text="Weekends are not available" /&gt;</code></pre>
                            </div>
                        </div>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>

        <!-- ==================== DashboardFileUpload ==================== -->
        <Card v-if="activeComponent === 'DashboardFileUpload'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">DashboardFileUpload</CardTitle>
                        <CardDescription class="mt-2 text-base">
                            Advanced file upload with temporary storage, drag & drop, image previews, progress tracking, and validation
                        </CardDescription>
                    </div>
                    <Badge variant="secondary">File Input</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="rounded-lg border-2 border-dashed bg-muted/30 p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <Eye class="h-5 w-5 text-primary" />
                        <h3 class="text-lg font-bold">Live Preview</h3>
                    </div>
                    <div class="space-y-6 rounded-lg bg-background p-6">
                        <div>
                            <Label for="demo-files">File Upload</Label>
                            <DashboardFileUpload
                                id="demo-files"
                                v-model="demoForm.files"
                                :multiple="true"
                                accept="image/*"
                                :max-file-size="5000000"
                                choose-label="Choose Images"
                                class="mt-2"
                            />
                            <Hint text="Upload images (max 5MB each)" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Import -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">📦 Import</h3>
                    <pre
                        class="rounded-lg bg-muted p-4 text-sm"
                    ><code>import DashboardFileUpload from '@common/components/dashboards/form/DashboardFileUpload.vue';</code></pre>
                </div>

                <!-- Props Table -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">⚙️ Props</h3>
                    <div class="overflow-hidden rounded-lg border">
                        <Table>
                            <TableHeader>
                                <TableRow class="bg-muted/50">
                                    <TableHead class="font-bold">Prop</TableHead>
                                    <TableHead class="font-bold">Type</TableHead>
                                    <TableHead class="font-bold">Default</TableHead>
                                    <TableHead class="font-bold">Description</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow class="bg-primary/5">
                                    <TableCell class="font-mono text-sm font-bold">modelValue</TableCell>
                                    <TableCell>
                                        <Badge variant="default">TemporaryFile[] | null</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>
                                        <strong>✅ Temporary uploaded files (v-model binding)</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">name</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'files[]'</code></TableCell>
                                    <TableCell>Form field name for submission</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">url</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Upload endpoint URL (required for auto upload)</TableCell>
                                </TableRow>
                                <TableRow class="bg-blue-500/5">
                                    <TableCell class="font-mono text-sm font-bold">accept</TableCell>
                                    <TableCell>
                                        <Badge variant="default">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'*'</code></TableCell>
                                    <TableCell>
                                        <strong>📄 Accepted file types (e.g., 'image/*', '.pdf', 'image/png,image/jpeg')</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-yellow-500/10">
                                    <TableCell class="font-mono text-sm font-bold">maxFileSize</TableCell>
                                    <TableCell>
                                        <Badge variant="default">number</Badge>
                                    </TableCell>
                                    <TableCell><code>5000000</code></TableCell>
                                    <TableCell>
                                        <strong>⚠️ Max file size in bytes (default: 5MB)</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-green-500/5">
                                    <TableCell class="font-mono text-sm font-bold">multiple</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>
                                        <strong>📁 Allow multiple file selection</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-green-500/5">
                                    <TableCell class="font-mono text-sm font-bold">auto</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>
                                        <strong>🚀 Automatically upload files to temporary storage on selection</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">customUpload</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Uses custom upload handler (temp file storage)</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">context</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'general'</code></TableCell>
                                    <TableCell>Context for organizing files (e.g., 'products', 'blogs', 'galleries')</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">fileLimit</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">number</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Limit total number of files</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">chooseLabel</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'Choose Files'</code></TableCell>
                                    <TableCell>Choose button label</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">uploadLabel</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'Upload'</code></TableCell>
                                    <TableCell>Upload button label</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">cancelLabel</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'Cancel'</code></TableCell>
                                    <TableCell>Cancel button label</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">showUploadButton</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Show upload button</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">showCancelButton</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Show cancel/clear button</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">invalidFileSizeMessage</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'{0}: Invalid file size...'</code></TableCell>
                                    <TableCell>Error message for file size validation</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">invalidFileTypeMessage</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'{0}: Invalid file type...'</code></TableCell>
                                    <TableCell>Error message for file type validation</TableCell>
                                </TableRow>
                                <TableRow class="bg-destructive/5">
                                    <TableCell class="font-mono text-sm font-bold">error</TableCell>
                                    <TableCell>
                                        <Badge variant="destructive">string | null</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>
                                        <strong>⚠️ Automatically shows red border when provided</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">disabled</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Disable the uploader</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">previewWidth</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">number</Badge>
                                    </TableCell>
                                    <TableCell><code>100</code></TableCell>
                                    <TableCell>Image preview width in pixels</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Events -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        🎯 Events
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="overflow-hidden rounded-lg border">
                            <Table>
                                <TableHeader>
                                    <TableRow class="bg-muted/50">
                                        <TableHead class="font-bold">Event</TableHead>
                                        <TableHead class="font-bold">Payload</TableHead>
                                        <TableHead class="font-bold">Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">update:modelValue</TableCell>
                                        <TableCell>
                                            <Badge>TemporaryFile[]</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when temporary files change (v-model)</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">select</TableCell>
                                        <TableCell>
                                            <Badge>FileUploadSelectEvent</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when files are selected</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">upload</TableCell>
                                        <TableCell>
                                            <Badge>FileUploadUploaderEvent</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when upload button is clicked</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">remove</TableCell>
                                        <TableCell>
                                            <Badge>{'{ file, files }'}</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when a file is removed</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">clear</TableCell>
                                        <TableCell>
                                            <Badge>void</Badge>
                                        </TableCell>
                                        <TableCell>Emitted when all files are cleared</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">error</TableCell>
                                        <TableCell>
                                            <Badge>any</Badge>
                                        </TableCell>
                                        <TableCell>Emitted on upload error</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">before-upload</TableCell>
                                        <TableCell>
                                            <Badge>any</Badge>
                                        </TableCell>
                                        <TableCell>Emitted before upload starts</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">progress</TableCell>
                                        <TableCell>
                                            <Badge>ProgressEvent</Badge>
                                        </TableCell>
                                        <TableCell>Emitted during upload progress</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">before-send</TableCell>
                                        <TableCell>
                                            <Badge>any</Badge>
                                        </TableCell>
                                        <TableCell>Emitted before request is sent to server</TableCell>
                                    </TableRow>
                                    <TableRow class="bg-green-500/5">
                                        <TableCell class="font-mono text-sm font-bold">temp-uploaded</TableCell>
                                        <TableCell>
                                            <Badge variant="default">TemporaryFile[]</Badge>
                                        </TableCell>
                                        <TableCell>
                                            <strong>🎉 Emitted when files are successfully uploaded to temporary storage</strong>
                                        </TableCell>
                                    </TableRow>
                                    <TableRow class="bg-red-500/5">
                                        <TableCell class="font-mono text-sm font-bold">temp-deleted</TableCell>
                                        <TableCell>
                                            <Badge variant="default">string</Badge>
                                        </TableCell>
                                        <TableCell>
                                            <strong>🗑️ Emitted when a temporary file is deleted (receives temp_path)</strong>
                                        </TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Features -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        ✨ Features
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="rounded-lg border p-4">
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Drag & Drop:</strong> Drag files directly into the upload area</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Image Previews:</strong> Automatic thumbnail generation for images</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>File Type Icons:</strong> Different icons for images, PDFs, and other files</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>File Size Display:</strong> Auto-formatted file sizes (B, KB, MB, GB)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Validation:</strong> File type and size validation with custom error messages</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Grid Layout:</strong> Responsive grid display for multiple files</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Remove Files:</strong> Individual file removal with hover buttons</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Uploaded Files Section:</strong> Separate display for successfully uploaded files</span>
                                </li>
                            </ul>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Usage Examples -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Examples
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="space-y-4">
                            <div>
                                <h4 class="mb-2 text-sm font-semibold">1. Basic Image Upload</h4>
                                <pre
                                    class="overflow-x-auto rounded bg-muted p-3 text-sm"
                                ><code>&lt;Label for="avatar"&gt;Profile Picture&lt;/Label&gt;
&lt;DashboardFileUpload
    id="avatar"
    v-model="form.avatar"
    accept="image/*"
    :multiple="false"
    :max-file-size="2000000"
    choose-label="Choose Image"
    :error="form.errors.avatar"
/&gt;
&lt;InputError :message="form.errors.avatar" /&gt;
&lt;Hint text="Maximum 2MB. JPG, PNG, or GIF" /&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="mb-2 text-sm font-semibold">2. Multiple Files with Custom Upload</h4>
                                <pre class="overflow-x-auto rounded bg-muted p-3 text-sm"><code>&lt;script setup&gt;
const handleUpload = async (event) => {
    const formData = new FormData();
    event.files.forEach((file) => {
        formData.append('files[]', file);
    });

    await axios.post('/api/upload', formData);
};
&lt;/script&gt;

&lt;template&gt;
    &lt;DashboardFileUpload
        v-model="files"
        :multiple="true"
        custom-upload
        @upload="handleUpload"
        accept="image/*,.pdf"
        :max-file-size="10000000"
    /&gt;
&lt;/template&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="mb-2 text-sm font-semibold">3. PDF Documents Only</h4>
                                <pre
                                    class="overflow-x-auto rounded bg-muted p-3 text-sm"
                                ><code>&lt;Label for="documents" required&gt;Upload Documents&lt;/Label&gt;
&lt;DashboardFileUpload
    id="documents"
    v-model="form.documents"
    accept=".pdf"
    :multiple="true"
    :file-limit="5"
    choose-label="Choose PDFs"
    :error="form.errors.documents"
/&gt;
&lt;Hint text="Upload up to 5 PDF files, max 10MB each" /&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="mb-2 text-sm font-semibold">4. Auto Upload to Server</h4>
                                <pre class="overflow-x-auto rounded bg-muted p-3 text-sm"><code>&lt;DashboardFileUpload
    v-model="files"
    url="/api/upload"
    :auto="true"
    :multiple="true"
    accept="image/*"
    @upload="onUploadComplete"
    @error="onUploadError"
/&gt;</code></pre>
                            </div>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Exposed Methods -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        🔧 Exposed Methods
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="overflow-hidden rounded-lg border">
                            <Table>
                                <TableHeader>
                                    <TableRow class="bg-muted/50">
                                        <TableHead class="font-bold">Method</TableHead>
                                        <TableHead class="font-bold">Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">clear()</TableCell>
                                        <TableCell>Clear all temporary files from storage and reset the component</TableCell>
                                    </TableRow>
                                    <TableRow class="bg-blue-500/5">
                                        <TableCell class="font-mono text-sm font-bold">getTempFiles()</TableCell>
                                        <TableCell>
                                            <strong>Returns the current array of temporary files (TemporaryFile[])</strong>
                                        </TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                        <div class="mt-3">
                            <pre class="overflow-x-auto rounded bg-muted p-3 text-sm"><code>&lt;script setup&gt;
const fileUploadRef = ref();

const clearAll = () => {
    fileUploadRef.value.clear();
};

const getCurrentFiles = () => {
    const tempFiles = fileUploadRef.value.getTempFiles();
    console.log('Current temporary files:', tempFiles);
};
&lt;/script&gt;

&lt;template&gt;
    &lt;DashboardFileUpload ref="fileUploadRef" /&gt;
&lt;/template&gt;</code></pre>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Backend Integration -->
                <Collapsible>
                    <CollapsibleTrigger
                        class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors"
                    >
                        <ChevronDown class="h-5 w-5" />
                        🔌 Backend Integration (Laravel)
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="space-y-4">
                            <div class="border rounded-lg p-4 bg-blue-500/5">
                                <h4 class="font-semibold mb-2 text-sm">📋 Overview</h4>
                                <p class="text-sm text-muted-foreground">
                                    The DashboardFileUpload component automatically uploads files to temporary storage.
                                    When the form is submitted, you need to move these temporary files to permanent storage using the FileUploadService.
                                </p>
                            </div>

                            <!-- Built-in Helper Methods -->
                            <div class="border rounded-lg p-4 bg-purple-500/5">
                                <h4 class="font-semibold mb-3 text-sm flex items-center gap-2">
                                    <span>🛠️</span>
                                    Built-in Helper Methods (BaseController)
                                </h4>
                                <p class="text-sm text-muted-foreground mb-3">
                                    When your controller extends <code>BaseController</code>, you automatically get access to these helper methods for file upload handling:
                                </p>

                                <div class="space-y-4">
                                    <!-- getExistingFilesForEdit -->
                                    <div class="border-l-2 border-primary pl-3">
                                        <code class="text-sm font-semibold text-primary">getExistingFilesForEdit($model, string $collection): array</code>
                                        <p class="text-xs text-muted-foreground mt-1 mb-2">
                                            Converts existing media library items to the format expected by DashboardFileUpload component.
                                        </p>
                                        <div class="text-xs space-y-1">
                                            <p><strong>When to use:</strong> In your <code>edit()</code> method to load existing files</p>
                                            <p><strong>Parameters:</strong></p>
                                            <ul class="list-disc list-inside ml-2 space-y-0.5">
                                                <li><code>$model</code> - The model instance (e.g., Product, Blog)</li>
                                                <li><code>$collection</code> - Media collection name (e.g., 'products', 'avatars')</li>
                                            </ul>
                                            <p><strong>Returns:</strong> Array of files formatted for the component</p>
                                        </div>
                                    </div>

                                    <!-- updateMediaFiles -->
                                    <div class="border-l-2 border-primary pl-3">
                                        <code class="text-sm font-semibold text-primary">updateMediaFiles($model, array $tempFiles, string $collection): int</code>
                                        <p class="text-xs text-muted-foreground mt-1 mb-2">
                                            Handles file updates during edit operations. Keeps existing files, removes deleted ones, and adds new uploads.
                                        </p>
                                        <div class="text-xs space-y-1">
                                            <p><strong>When to use:</strong> In your <code>update()</code> method to handle file changes</p>
                                            <p><strong>Parameters:</strong></p>
                                            <ul class="list-disc list-inside ml-2 space-y-0.5">
                                                <li><code>$model</code> - The model instance to update</li>
                                                <li><code>$tempFiles</code> - Array from <code>$request-&gt;temp_files</code></li>
                                                <li><code>$collection</code> - Media collection name</li>
                                            </ul>
                                            <p><strong>Returns:</strong> Number of new files added</p>
                                        </div>
                                    </div>

                                    <!-- getNewTempFiles -->
                                    <div class="border-l-2 border-primary pl-3">
                                        <code class="text-sm font-semibold text-primary">getNewTempFiles(array $tempFiles): array</code>
                                        <p class="text-xs text-muted-foreground mt-1 mb-2">
                                            Filters out only new temporary files (excludes existing media files).
                                        </p>
                                        <div class="text-xs space-y-1">
                                            <p><strong>When to use:</strong> In error handling to cleanup only new uploads</p>
                                            <p><strong>Parameters:</strong></p>
                                            <ul class="list-disc list-inside ml-2 space-y-0.5">
                                                <li><code>$tempFiles</code> - Array from <code>$request-&gt;temp_files</code></li>
                                            </ul>
                                            <p><strong>Returns:</strong> Array containing only new temporary files</p>
                                        </div>
                                    </div>

                                    <!-- successWithToast -->
                                    <div class="border-l-2 border-primary pl-3">
                                        <code class="text-sm font-semibold text-primary">successWithToast(string $message, string $title = 'Success', ?string $route = null)</code>
                                        <p class="text-xs text-muted-foreground mt-1 mb-2">
                                            Returns a redirect response with a success toast notification.
                                        </p>
                                        <div class="text-xs space-y-1">
                                            <p><strong>When to use:</strong> After successful create/update operations</p>
                                            <p><strong>Parameters:</strong></p>
                                            <ul class="list-disc list-inside ml-2 space-y-0.5">
                                                <li><code>$message</code> - Toast message to display</li>
                                                <li><code>$title</code> - Toast title (default: 'Success')</li>
                                                <li><code>$route</code> - Route name to redirect to (default: back)</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- errorWithToast -->
                                    <div class="border-l-2 border-primary pl-3">
                                        <code class="text-sm font-semibold text-primary">errorWithToast(string $message, string $title = 'Error', ?string $route = null)</code>
                                        <p class="text-xs text-muted-foreground mt-1 mb-2">
                                            Returns a redirect response with an error toast notification.
                                        </p>
                                        <div class="text-xs space-y-1">
                                            <p><strong>When to use:</strong> For error scenarios without exceptions</p>
                                            <p><strong>Parameters:</strong></p>
                                            <ul class="list-disc list-inside ml-2 space-y-0.5">
                                                <li><code>$message</code> - Toast message to display</li>
                                                <li><code>$title</code> - Toast title (default: 'Error')</li>
                                                <li><code>$route</code> - Route name to redirect to (default: back)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Complete Controller Example -->
                            <div>
                                <h4 class="font-semibold mb-2 text-sm">📝 Complete Controller Example</h4>
                                <p class="text-xs text-muted-foreground mb-2">Here's a full CRUD controller using all the built-in helper methods:</p>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Navigation\SuperAdminPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductController extends BaseController
{
    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        return Inertia::render(SuperAdminPath::view('products/Create'));
    }

    /**
     * Store a newly created product with file uploads
     */
    public function store(Request $request)
    {
        $request-&gt;validate([
            'name' =&gt; 'required|string|max:255',
            'temp_files' =&gt; 'required|array|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Create the product
            $product = Product::create([
                'name' =&gt; $request-&gt;name,
            ]);

            // Move temporary files to media library
            $filesAdded = $this-&gt;fileUploadService-&gt;moveToMediaLibrary(
                $product,
                $request-&gt;temp_files,
                'products'
            );

            DB::commit();

            // ✅ Using built-in helper method
            return $this-&gt;successWithToast(
                "Product '{$product-&gt;name}' created with {$filesAdded} images.",
                'Product created successfully',
                'super-admin.products.index'
            );
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up temporary files on error
            $this-&gt;fileUploadService-&gt;cleanupTempFiles($request-&gt;temp_files);

            return back()-&gt;withErrors([
                'temp_files' =&gt; 'Failed to create product: ' . $e-&gt;getMessage(),
            ])-&gt;withInput();
        }
    }

    /**
     * Show the form for editing a product with existing files
     */
    public function edit(Product $product)
    {
        // ✅ Using built-in helper method
        $existingFiles = $this-&gt;getExistingFilesForEdit($product, 'products');

        return Inertia::render(SuperAdminPath::view('products/Edit'), [
            'product' =&gt; $product,
            'existingFiles' =&gt; $existingFiles,
        ]);
    }

    /**
     * Update a product and handle file changes
     */
    public function update(Request $request, Product $product)
    {
        $request-&gt;validate([
            'name' =&gt; 'required|string|max:255',
            'temp_files' =&gt; 'sometimes|array',
        ]);

        DB::beginTransaction();

        try {
            // Update the product
            $product-&gt;update([
                'name' =&gt; $request-&gt;name,
            ]);

            // Handle file updates if provided
            if ($request-&gt;has('temp_files')) {
                // ✅ Using built-in helper method
                $this-&gt;updateMediaFiles(
                    $product,
                    $request-&gt;temp_files,
                    'products'
                );
            }

            DB::commit();

            // ✅ Using built-in helper method
            return $this-&gt;successWithToast(
                "Product '{$product-&gt;name}' has been updated.",
                'Product updated successfully',
                'super-admin.products.index'
            );
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up only new temporary files on error
            if ($request-&gt;has('temp_files')) {
                // ✅ Using built-in helper method
                $newTempFiles = $this-&gt;getNewTempFiles($request-&gt;temp_files);
                if (! empty($newTempFiles)) {
                    $this-&gt;fileUploadService-&gt;cleanupTempFiles($newTempFiles);
                }
            }

            return back()-&gt;withErrors([
                'temp_files' =&gt; 'Failed to update product: ' . $e-&gt;getMessage(),
            ])-&gt;withInput();
        }
    }
}</code></pre>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-2 text-sm">🎨 Frontend Form Example</h4>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;script setup lang="ts"&gt;
import { useForm } from '@inertiajs/vue3';
import DashboardFileUpload from '@common/components/dashboards/form/DashboardFileUpload.vue';

const props = defineProps&lt;{
    product?: Product;
    existingFiles?: TemporaryFile[];
}&gt;();

const form = useForm({
    name: props.product?.name || '',
    temp_files: props.existingFiles || [],
});

const submit = () => {
    if (props.product) {
        form.put(route('super-admin.products.update', props.product.id));
    } else {
        form.post(route('super-admin.products.store'));
    }
};
&lt;/script&gt;

&lt;template&gt;
    &lt;form @submit.prevent="submit"&gt;
        &lt;Label for="name" required&gt;Product Name&lt;/Label&gt;
        &lt;DashboardTextInput
            id="name"
            v-model="form.name"
            :error="form.errors.name"
        /&gt;

        &lt;Label for="images" required&gt;Product Images&lt;/Label&gt;
        &lt;DashboardFileUpload
            id="images"
            v-model="form.temp_files"
            accept="image/*"
            :multiple="true"
            :file-limit="5"
            context="products"
            :error="form.errors.temp_files"
        /&gt;

        &lt;DashboardButton type="submit" :loading="form.processing"&gt;
            {{ product ? 'Update' : 'Create' }} Product
        &lt;/DashboardButton&gt;
    &lt;/form&gt;
&lt;/template&gt;</code></pre>
                            </div>

                            <div class="border rounded-lg p-4 bg-yellow-500/5">
                                <h4 class="font-semibold mb-2 text-sm flex items-center gap-2">
                                    <span>💡</span>
                                    Key Points
                                </h4>
                                <ul class="space-y-2 text-sm text-muted-foreground">
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary">•</span>
                                        <span><strong>Extend BaseController:</strong> Your controller must extend <code>BaseController</code> to access helper methods</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary">•</span>
                                        <span><strong>Temporary Storage:</strong> Files are uploaded to temporary storage first, not directly attached to models</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary">•</span>
                                        <span><strong>FileUploadService:</strong> Automatically injected into BaseController via constructor</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary">•</span>
                                        <span><strong>Helper Methods:</strong> Use <code>getExistingFilesForEdit()</code>, <code>updateMediaFiles()</code>, <code>getNewTempFiles()</code> for cleaner code</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary">•</span>
                                        <span><strong>Cleanup:</strong> Always cleanup temp files on errors using <code>cleanupTempFiles()</code></span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary">•</span>
                                        <span><strong>Context:</strong> Use the <code>context</code> prop to organize files by type (e.g., 'products', 'blogs')</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary">•</span>
                                        <span><strong>Transactions:</strong> Wrap file operations in database transactions for data consistency</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary">•</span>
                                        <span><strong>Toast Helpers:</strong> Use <code>successWithToast()</code> and <code>errorWithToast()</code> for consistent user feedback</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="border rounded-lg p-4 bg-green-500/5">
                                <h4 class="font-semibold mb-2 text-sm">🔄 Request Data Structure</h4>
                                <p class="text-sm text-muted-foreground mb-2">The <code>temp_files</code> array contains objects with:</p>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>// New uploaded files:
[
    {
        "temp_path": "temp-uploads/products/abc123.jpg",
        "original_name": "product-image.jpg",
        "size": 245678,
        "mime_type": "image/jpeg",
        "url": "/storage/temp-uploads/products/abc123.jpg",
        "is_existing": false
    }
]

// Existing media files (from edit):
[
    {
        "temp_path": null,
        "original_name": "existing-product.jpg",
        "size": 189234,
        "mime_type": "image/jpeg",
        "url": "/storage/products/existing-product.jpg",
        "media_id": 42,
        "is_existing": true
    }
]</code></pre>
                            </div>
                        </div>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>

        <!-- ==================== DashboardCheckbox ==================== -->
        <Card v-if="activeComponent === 'DashboardCheckbox'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">DashboardCheckbox</CardTitle>
                        <CardDescription class="mt-2 text-base"> Checkbox component with label support and array binding </CardDescription>
                    </div>
                    <Badge variant="secondary">Form Input</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="space-y-4">
                    <h3 class="flex items-center gap-2 text-xl font-bold">
                        <Eye class="h-5 w-5 text-primary" />
                        Live Preview
                    </h3>
                    <div class="space-y-6 rounded-lg border bg-background p-6">
                        <div class="space-y-4">
                            <div>
                                <Label>Single Checkbox (Binary Mode)</Label>
                                <Hint>Simple true/false checkbox</Hint>
                                <div class="mt-2">
                                    <DashboardCheckbox v-model="demoForm.checkbox" label="I agree to the terms and conditions" id="terms" />
                                </div>
                                <p class="mt-2 text-sm text-muted-foreground">
                                    Value: <code class="rounded bg-muted px-2 py-1">{{ demoForm.checkbox }}</code>
                                </p>
                            </div>

                            <div>
                                <Label>Multiple Checkboxes (Array Mode)</Label>
                                <Hint>Select multiple options into an array</Hint>
                                <div class="mt-2 space-y-2">
                                    <DashboardCheckbox
                                        v-model="demoForm.checkboxArray"
                                        label="Email Notifications"
                                        value="email"
                                        :binary="false"
                                        id="notify-email"
                                    />
                                    <DashboardCheckbox
                                        v-model="demoForm.checkboxArray"
                                        label="SMS Notifications"
                                        value="sms"
                                        :binary="false"
                                        id="notify-sms"
                                    />
                                    <DashboardCheckbox
                                        v-model="demoForm.checkboxArray"
                                        label="Push Notifications"
                                        value="push"
                                        :binary="false"
                                        id="notify-push"
                                    />
                                </div>
                                <p class="mt-2 text-sm text-muted-foreground">
                                    Selected: <code class="rounded bg-muted px-2 py-1">{{ demoForm.checkboxArray }}</code>
                                </p>
                            </div>

                            <div>
                                <Label>Label Position</Label>
                                <Hint>Label can be on left or right</Hint>
                                <div class="mt-2 space-y-2">
                                    <DashboardCheckbox v-model="demoForm.checkbox" label="Label on right (default)" label-position="right" />
                                    <DashboardCheckbox v-model="demoForm.checkbox" label="Label on left" label-position="left" />
                                </div>
                            </div>

                            <div>
                                <Label>Disabled State</Label>
                                <Hint>Checkbox can be disabled</Hint>
                                <div class="mt-2 space-y-2">
                                    <DashboardCheckbox :model-value="true" label="Checked and disabled" disabled />
                                    <DashboardCheckbox :model-value="false" label="Unchecked and disabled" disabled />
                                </div>
                            </div>

                            <div>
                                <Label>Error State</Label>
                                <Hint>Shows red border when error is present</Hint>
                                <div class="mt-2">
                                    <DashboardCheckbox
                                        v-model="demoForm.checkbox"
                                        label="You must agree to continue"
                                        error="This field is required"
                                    />
                                    <p class="mt-1 text-sm text-destructive">This field is required</p>
                                </div>
                            </div>

                            <div>
                                <Label>Without Label</Label>
                                <Hint>Checkbox can be used without a label</Hint>
                                <div class="mt-2">
                                    <DashboardCheckbox v-model="demoForm.checkbox" :show-label="false" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Props -->
                <div class="space-y-4">
                    <h3 class="flex items-center gap-2 text-xl font-bold">⚙️ Props</h3>
                    <div class="overflow-hidden rounded-lg border">
                        <Table>
                            <TableHeader>
                                <TableRow class="bg-muted/50">
                                    <TableHead class="font-bold">Prop</TableHead>
                                    <TableHead class="font-bold">Type</TableHead>
                                    <TableHead class="font-bold">Default</TableHead>
                                    <TableHead class="font-bold">Description</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">modelValue</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean | any</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Checkbox value (v-model)</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">value</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">any</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Value for array binding</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">label</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>''</code></TableCell>
                                    <TableCell>Label text</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">error</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string | null</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>Error message (shows red border)</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">disabled</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Disables checkbox</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">required</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Required attribute</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">binary</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Binary mode (true/false only)</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">labelPosition</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'right'</code></TableCell>
                                    <TableCell>'left' | 'right'</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">showLabel</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Show or hide label</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">id</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Checkbox id attribute</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Events -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📡 Events
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="overflow-hidden rounded-lg border">
                            <Table>
                                <TableHeader>
                                    <TableRow class="bg-muted/50">
                                        <TableHead class="font-bold">Event</TableHead>
                                        <TableHead class="font-bold">Payload</TableHead>
                                        <TableHead class="font-bold">Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">update:modelValue</TableCell>
                                        <TableCell><code>boolean | any</code></TableCell>
                                        <TableCell>Emitted when checkbox value changes</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">change</TableCell>
                                        <TableCell><code>Event</code></TableCell>
                                        <TableCell>Native change event</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Usage Example -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Examples
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <pre class="overflow-x-auto rounded-lg bg-muted p-4 text-sm"><code>&lt;!-- Single checkbox (binary mode) --&gt;
&lt;DashboardCheckbox
    v-model="form.accepted"
    label="I accept the terms"
    :error="form.errors.accepted"
/&gt;

&lt;!-- Multiple checkboxes (array mode) --&gt;
&lt;DashboardCheckbox
    v-model="form.notifications"
    label="Email Notifications"
    value="email"
    :binary="false"
/&gt;

&lt;!-- Label on left --&gt;
&lt;DashboardCheckbox
    v-model="form.rememberMe"
    label="Remember me"
    label-position="left"
/&gt;

&lt;!-- Without label --&gt;
&lt;DashboardCheckbox
    v-model="form.selected"
    :show-label="false"
/&gt;</code></pre>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>

        <!-- ==================== DashboardToggle ==================== -->
        <Card v-if="activeComponent === 'DashboardToggle'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">DashboardToggle</CardTitle>
                        <CardDescription class="mt-2 text-base"> Toggle switch component for boolean values with label support </CardDescription>
                    </div>
                    <Badge variant="secondary">Form Input</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="space-y-4">
                    <h3 class="flex items-center gap-2 text-xl font-bold">
                        <Eye class="h-5 w-5 text-primary" />
                        Live Preview
                    </h3>
                    <div class="space-y-6 rounded-lg border bg-background p-6">
                        <div class="space-y-4">
                            <div>
                                <Label>Basic Toggle</Label>
                                <Hint>Simple on/off switch</Hint>
                                <div class="mt-2">
                                    <DashboardToggle v-model="demoForm.toggle" label="Enable notifications" id="notify" />
                                </div>
                                <p class="mt-2 text-sm text-muted-foreground">
                                    Value: <code class="rounded bg-muted px-2 py-1">{{ demoForm.toggle }}</code>
                                </p>
                            </div>

                            <div>
                                <Label>Toggle with Hint</Label>
                                <Hint>Shows additional helper text</Hint>
                                <div class="mt-2">
                                    <DashboardToggle
                                        v-model="demoForm.toggle"
                                        label="Dark Mode"
                                        hint="Switch between light and dark themes"
                                        id="dark-mode"
                                    />
                                </div>
                            </div>

                            <div>
                                <Label>Label Position</Label>
                                <Hint>Label can be on left or right</Hint>
                                <div class="mt-2 space-y-3">
                                    <DashboardToggle v-model="demoForm.toggle" label="Label on right (default)" label-position="right" />
                                    <DashboardToggle v-model="demoForm.toggle" label="Label on left" label-position="left" />
                                </div>
                            </div>

                            <div>
                                <Label>Required Toggle</Label>
                                <Hint>Shows asterisk for required fields</Hint>
                                <div class="mt-2">
                                    <DashboardToggle v-model="demoForm.toggle" label="Accept terms and conditions" required />
                                </div>
                            </div>

                            <div>
                                <Label>Disabled State</Label>
                                <Hint>Toggle can be disabled</Hint>
                                <div class="mt-2 space-y-3">
                                    <DashboardToggle :model-value="true" label="Enabled and disabled" disabled />
                                    <DashboardToggle :model-value="false" label="Disabled and off" disabled />
                                </div>
                            </div>

                            <div>
                                <Label>Error State</Label>
                                <Hint>Shows red border and error message</Hint>
                                <div class="mt-2">
                                    <DashboardToggle v-model="demoForm.toggle" label="You must accept to continue" error="This field is required" />
                                </div>
                            </div>

                            <div>
                                <Label>Without Label</Label>
                                <Hint>Toggle can be used without a label</Hint>
                                <div class="mt-2">
                                    <DashboardToggle v-model="demoForm.toggle" :show-label="false" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Props -->
                <div class="space-y-4">
                    <h3 class="flex items-center gap-2 text-xl font-bold">⚙️ Props</h3>
                    <div class="overflow-hidden rounded-lg border">
                        <Table>
                            <TableHeader>
                                <TableRow class="bg-muted/50">
                                    <TableHead class="font-bold">Prop</TableHead>
                                    <TableHead class="font-bold">Type</TableHead>
                                    <TableHead class="font-bold">Default</TableHead>
                                    <TableHead class="font-bold">Description</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">modelValue</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Toggle value (v-model)</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">label</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>''</code></TableCell>
                                    <TableCell>Label text</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">size</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'small'</code></TableCell>
                                    <TableCell>'small' | 'medium' | 'large'</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">error</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string | null</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>Error message (shows red border)</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">disabled</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Disables toggle</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">required</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Shows asterisk, required attribute</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">labelPosition</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'right'</code></TableCell>
                                    <TableCell>'left' | 'right'</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">showLabel</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Show or hide label</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">hint</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>''</code></TableCell>
                                    <TableCell>Helper text below toggle</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">id</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Toggle id attribute</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Events -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📡 Events
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="overflow-hidden rounded-lg border">
                            <Table>
                                <TableHeader>
                                    <TableRow class="bg-muted/50">
                                        <TableHead class="font-bold">Event</TableHead>
                                        <TableHead class="font-bold">Payload</TableHead>
                                        <TableHead class="font-bold">Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">update:modelValue</TableCell>
                                        <TableCell><code>boolean</code></TableCell>
                                        <TableCell>Emitted when toggle value changes</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">change</TableCell>
                                        <TableCell><code>Event</code></TableCell>
                                        <TableCell>Native change event</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Usage Example -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Examples
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <pre class="overflow-x-auto rounded-lg bg-muted p-4 text-sm"><code>&lt;!-- Basic toggle --&gt;
&lt;DashboardToggle
    v-model="form.enabled"
    label="Enable feature"
    :error="form.errors.enabled"
/&gt;

&lt;!-- Toggle with hint --&gt;
&lt;DashboardToggle
    v-model="form.darkMode"
    label="Dark Mode"
    hint="Switch between light and dark themes"
/&gt;

&lt;!-- Required toggle --&gt;
&lt;DashboardToggle
    v-model="form.acceptTerms"
    label="Accept terms and conditions"
    required
/&gt;

&lt;!-- Label on left --&gt;
&lt;DashboardToggle
    v-model="form.notifications"
    label="Notifications"
    label-position="left"
/&gt;</code></pre>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>

        <!-- ==================== DashboardRadioButton ==================== -->
        <Card v-if="activeComponent === 'DashboardRadioButton'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">DashboardRadioButton</CardTitle>
                        <CardDescription class="mt-2 text-base"> Radio button component for single selection from multiple options </CardDescription>
                    </div>
                    <Badge variant="secondary">Form Input</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="space-y-4">
                    <h3 class="flex items-center gap-2 text-xl font-bold">
                        <Eye class="h-5 w-5 text-primary" />
                        Live Preview
                    </h3>
                    <div class="space-y-6 rounded-lg border bg-background p-6">
                        <div class="space-y-4">
                            <div>
                                <Label>Basic Radio Group</Label>
                                <Hint>Select one option from multiple choices</Hint>
                                <div class="mt-2 space-y-2">
                                    <DashboardRadioButton v-model="demoForm.radio" label="Option 1" value="option1" name="demo-radio" id="radio1" />
                                    <DashboardRadioButton v-model="demoForm.radio" label="Option 2" value="option2" name="demo-radio" id="radio2" />
                                    <DashboardRadioButton v-model="demoForm.radio" label="Option 3" value="option3" name="demo-radio" id="radio3" />
                                </div>
                                <p class="mt-2 text-sm text-muted-foreground">
                                    Selected: <code class="rounded bg-muted px-2 py-1">{{ demoForm.radio || 'none' }}</code>
                                </p>
                            </div>

                            <div>
                                <Label>Radio with Hints</Label>
                                <Hint>Each option can have helper text</Hint>
                                <div class="mt-2 space-y-3">
                                    <DashboardRadioButton
                                        v-model="demoForm.radio"
                                        label="Free Plan"
                                        value="free"
                                        hint="Perfect for individuals"
                                        name="plan"
                                    />
                                    <DashboardRadioButton v-model="demoForm.radio" label="Pro Plan" value="pro" hint="For small teams" name="plan" />
                                    <DashboardRadioButton
                                        v-model="demoForm.radio"
                                        label="Enterprise Plan"
                                        value="enterprise"
                                        hint="For large organizations"
                                        name="plan"
                                    />
                                </div>
                            </div>

                            <div>
                                <Label>Label Position</Label>
                                <Hint>Label can be on left or right</Hint>
                                <div class="mt-2 space-y-2">
                                    <DashboardRadioButton
                                        v-model="demoForm.radio"
                                        label="Label on right (default)"
                                        value="right"
                                        label-position="right"
                                        name="position"
                                    />
                                    <DashboardRadioButton
                                        v-model="demoForm.radio"
                                        label="Label on left"
                                        value="left"
                                        label-position="left"
                                        name="position"
                                    />
                                </div>
                            </div>

                            <div>
                                <Label>Disabled State</Label>
                                <Hint>Radio buttons can be disabled</Hint>
                                <div class="mt-2 space-y-2">
                                    <DashboardRadioButton :model-value="'selected'" label="Selected and disabled" value="selected" disabled />
                                    <DashboardRadioButton :model-value="'selected'" label="Not selected and disabled" value="not" disabled />
                                </div>
                            </div>

                            <div>
                                <Label>Error State</Label>
                                <Hint>Shows red border and error message</Hint>
                                <div class="mt-2 space-y-2">
                                    <DashboardRadioButton
                                        v-model="demoForm.radio"
                                        label="Option A"
                                        value="a"
                                        error="Please select an option"
                                        name="error-demo"
                                    />
                                    <DashboardRadioButton
                                        v-model="demoForm.radio"
                                        label="Option B"
                                        value="b"
                                        error="Please select an option"
                                        name="error-demo"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Props -->
                <div class="space-y-4">
                    <h3 class="flex items-center gap-2 text-xl font-bold">⚙️ Props</h3>
                    <div class="overflow-hidden rounded-lg border">
                        <Table>
                            <TableHeader>
                                <TableRow class="bg-muted/50">
                                    <TableHead class="font-bold">Prop</TableHead>
                                    <TableHead class="font-bold">Type</TableHead>
                                    <TableHead class="font-bold">Default</TableHead>
                                    <TableHead class="font-bold">Description</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">modelValue</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">any</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>Radio value (v-model)</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">value</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">any</Badge>
                                    </TableCell>
                                    <TableCell><em>required</em></TableCell>
                                    <TableCell>Value when selected</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">label</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>''</code></TableCell>
                                    <TableCell>Label text</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">name</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Name for grouping radios</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">error</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string | null</Badge>
                                    </TableCell>
                                    <TableCell><code>null</code></TableCell>
                                    <TableCell>Error message (shows red border)</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">disabled</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Disables radio button</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">required</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Shows asterisk, required attribute</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">labelPosition</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'right'</code></TableCell>
                                    <TableCell>'left' | 'right'</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">showLabel</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>true</code></TableCell>
                                    <TableCell>Show or hide label</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">hint</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>''</code></TableCell>
                                    <TableCell>Helper text below radio</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">id</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>Radio id attribute</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Events -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📡 Events
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="overflow-hidden rounded-lg border">
                            <Table>
                                <TableHeader>
                                    <TableRow class="bg-muted/50">
                                        <TableHead class="font-bold">Event</TableHead>
                                        <TableHead class="font-bold">Payload</TableHead>
                                        <TableHead class="font-bold">Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">update:modelValue</TableCell>
                                        <TableCell><code>any</code></TableCell>
                                        <TableCell>Emitted when radio value changes</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">change</TableCell>
                                        <TableCell><code>Event</code></TableCell>
                                        <TableCell>Native change event</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Usage Example -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Examples
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <pre class="overflow-x-auto rounded-lg bg-muted p-4 text-sm"><code>&lt;!-- Basic radio group --&gt;
&lt;Label for="gender" required&gt;Gender&lt;/Label&gt;
&lt;div class="space-y-2"&gt;
    &lt;DashboardRadioButton
        v-model="form.gender"
        label="Male"
        value="male"
        name="gender"
        :error="form.errors.gender"
    /&gt;
    &lt;DashboardRadioButton
        v-model="form.gender"
        label="Female"
        value="female"
        name="gender"
        :error="form.errors.gender"
    /&gt;
    &lt;DashboardRadioButton
        v-model="form.gender"
        label="Other"
        value="other"
        name="gender"
        :error="form.errors.gender"
    /&gt;
&lt;/div&gt;

&lt;!-- Radio with hints --&gt;
&lt;Label&gt;Select a plan&lt;/Label&gt;
&lt;div class="space-y-3"&gt;
    &lt;DashboardRadioButton
        v-model="form.plan"
        label="Free Plan"
        value="free"
        hint="Perfect for individuals"
        name="plan"
    /&gt;
    &lt;DashboardRadioButton
        v-model="form.plan"
        label="Pro Plan"
        value="pro"
        hint="For small teams"
        name="plan"
    /&gt;
&lt;/div&gt;</code></pre>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>

        <!-- ==================== DashboardButton ==================== -->
        <Card v-if="activeComponent === 'DashboardButton'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">DashboardButton</CardTitle>
                        <CardDescription class="mt-2 text-base"> Button with loading states, variants, and custom icons </CardDescription>
                    </div>
                    <Badge variant="secondary">Action</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="rounded-lg border-2 border-dashed bg-muted/30 p-6">
                    <div class="mb-4 flex items-center gap-2">
                        <Eye class="h-5 w-5 text-primary" />
                        <h3 class="text-lg font-bold">Live Preview</h3>
                    </div>
                    <div class="rounded-lg bg-background p-6">
                        <div class="flex flex-wrap gap-3">
                            <DashboardButton variant="default">Default</DashboardButton>
                            <DashboardButton variant="destructive">Destructive</DashboardButton>
                            <DashboardButton variant="outline">Outline</DashboardButton>
                            <DashboardButton variant="secondary">Secondary</DashboardButton>
                            <DashboardButton variant="ghost">Ghost</DashboardButton>
                            <DashboardButton :loading="true">Loading</DashboardButton>
                        </div>
                    </div>
                </div>

                <!-- Import -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">📦 Import</h3>
                    <pre
                        class="rounded-lg bg-muted p-4 text-sm"
                    ><code>import DashboardButton from '@common/components/dashboards/form/DashboardButton.vue';</code></pre>
                </div>

                <!-- Props Table -->
                <div>
                    <h3 class="mb-3 text-lg font-bold">⚙️ Props</h3>
                    <div class="overflow-hidden rounded-lg border">
                        <Table>
                            <TableHeader>
                                <TableRow class="bg-muted/50">
                                    <TableHead class="font-bold">Prop</TableHead>
                                    <TableHead class="font-bold">Type</TableHead>
                                    <TableHead class="font-bold">Default</TableHead>
                                    <TableHead class="font-bold">Description</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow class="bg-blue-500/5">
                                    <TableCell class="font-mono text-sm font-bold">variant</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'default'</code></TableCell>
                                    <TableCell>
                                        <strong>
                                            'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link' | 'success' | 'warning' |
                                            'gradient' | 'glass'
                                        </strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">size</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'default'</code></TableCell>
                                    <TableCell>'xs' | 'sm' | 'default' | 'lg' | 'xl' | 'icon'</TableCell>
                                </TableRow>
                                <TableRow class="bg-yellow-500/10">
                                    <TableCell class="font-mono text-sm font-bold">loading</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>
                                        <strong>⏳ Shows loading spinner and disables button</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">loadingText</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell>-</TableCell>
                                    <TableCell>Custom text during loading</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">loadingPosition</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'after'</code></TableCell>
                                    <TableCell>'before' | 'after'</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">loadingIcon</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'circle'</code></TableCell>
                                    <TableCell> 'circle' | 'spinner' | 'rotate' | 'refresh' | 'gear' | 'dot' | 'disc' | 'none' </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">disabled</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>Disables button</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell class="font-mono text-sm">type</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">string</Badge>
                                    </TableCell>
                                    <TableCell><code>'button'</code></TableCell>
                                    <TableCell>'button' | 'submit' | 'reset'</TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Slots -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        🎯 Slots
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="overflow-hidden rounded-lg border">
                            <Table>
                                <TableHeader>
                                    <TableRow class="bg-muted/50">
                                        <TableHead class="font-bold">Slot</TableHead>
                                        <TableHead class="font-bold">Description</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">default</TableCell>
                                        <TableCell>Button content (text, elements)</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-mono text-sm">icon</TableCell>
                                        <TableCell>Icon slot (hidden when loading)</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Usage Example -->
                <Collapsible>
                    <CollapsibleTrigger class="flex items-center gap-2 text-lg font-bold transition-colors hover:text-primary">
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Examples
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <pre class="overflow-x-auto rounded-lg bg-muted p-4 text-sm"><code>&lt;!-- Submit button with loading --&gt;
&lt;DashboardButton
    type="submit"
    :loading="form.processing"
&gt;
    Create User
&lt;/DashboardButton&gt;

&lt;!-- Delete button --&gt;
&lt;DashboardButton
    variant="destructive"
    @click="deleteItem"
&gt;
    Delete
&lt;/DashboardButton&gt;

&lt;!-- Button with custom loading --&gt;
&lt;DashboardButton
    :loading="saving"
    loading-text="Saving..."
    loading-icon="refresh"
&gt;
    Save Changes
&lt;/DashboardButton&gt;</code></pre>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>
    </div>
</template>
