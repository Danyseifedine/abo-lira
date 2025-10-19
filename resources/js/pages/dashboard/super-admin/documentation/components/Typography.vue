<script setup lang="ts">
import { ref } from 'vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@ui/card';
import { Badge } from '@ui/badge';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@ui/table';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@ui/collapsible';
import { Label } from '@ui/label';
import Hint from '@common/components/dashboards/typography/Hint.vue';
import InputError from '@shared/components/InputError.vue';
import DashboardTextInput from '@common/components/dashboards/form/DashboardTextInput.vue';
import { ChevronDown, Eye } from 'lucide-vue-next';

const activeComponent = ref<string | null>('Hint');

// Demo form state
const demoForm = ref({
    email: '',
    password: '',
    errors: {
        email: 'This email is already taken',
        password: 'Password must be at least 8 characters',
    } as Record<string, string>,
});

const components = [
    { id: 'Hint', name: 'Hint', color: 'default' },
    { id: 'Label', name: 'Label', color: 'secondary' },
    { id: 'InputError', name: 'Input Error', color: 'outline' },
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
                <CardTitle>Typography Components</CardTitle>
                <CardDescription>Click a component below to view its documentation and live preview</CardDescription>
            </CardHeader>
            <CardContent>
                <div class="flex flex-wrap gap-3">
                    <Badge
                        v-for="component in components"
                        :key="component.id"
                        :variant="activeComponent === component.id ? 'default' : 'outline'"
                        class="cursor-pointer px-4 py-2 text-sm hover:bg-primary/10 transition-colors"
                        @click="selectComponent(component.id)"
                    >
                        {{ component.name }}
                    </Badge>
                </div>
            </CardContent>
        </Card>

        <!-- ==================== Hint ==================== -->
        <Card v-if="activeComponent === 'Hint'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">Hint</CardTitle>
                        <CardDescription class="text-base mt-2">
                            Small muted text for hints, descriptions, or helper messages below form inputs
                        </CardDescription>
                    </div>
                    <Badge variant="secondary">Helper Text</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="bg-muted/30 border-2 border-dashed rounded-lg p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <Eye class="h-5 w-5 text-primary" />
                        <h3 class="font-bold text-lg">Live Preview</h3>
                    </div>
                    <div class="bg-background rounded-lg p-6 space-y-6">
                        <div>
                            <Label for="demo-hint-email">Email Address</Label>
                            <DashboardTextInput
                                id="demo-hint-email"
                                v-model="demoForm.email"
                                type="email"
                                placeholder="your@email.com"
                                class="mt-2"
                            />
                            <Hint text="We'll never share your email with anyone else." class="mt-1" />
                        </div>
                        <div>
                            <Label for="demo-hint-password" required>Password with Error</Label>
                            <DashboardTextInput
                                id="demo-hint-password"
                                v-model="demoForm.password"
                                type="password"
                                placeholder="Enter password"
                                :error="demoForm.errors.email"
                                class="mt-2"
                            />
                            <Hint text="This email is already taken" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Import -->
                <div>
                    <h3 class="font-bold text-lg mb-3">📦 Import</h3>
                    <pre class="bg-muted p-4 rounded-lg text-sm"><code>import Hint from '@common/components/dashboards/typography/Hint.vue';</code></pre>
                </div>

                <!-- Props Table -->
                <div>
                    <h3 class="font-bold text-lg mb-3">⚙️ Props</h3>
                    <div class="border rounded-lg overflow-hidden">
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
                                    <TableCell class="font-mono text-sm font-bold">text</TableCell>
                                    <TableCell>
                                        <Badge variant="default">string | null | undefined</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>
                                        <strong>✅ The hint text to display. Can be null/undefined (renders empty)</strong>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Styling Details -->
                <Collapsible>
                    <CollapsibleTrigger
                        class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors"
                    >
                        <ChevronDown class="h-5 w-5" />
                        🎨 Styling Details
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="border rounded-lg p-4">
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Font Size:</strong> Extra small (<code class="bg-muted px-1.5 py-0.5 rounded text-xs">text-xs</code>)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Color:</strong> Muted foreground (<code class="bg-muted px-1.5 py-0.5 rounded text-xs">text-muted-foreground</code>)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Tag:</strong> Paragraph (&lt;p&gt;)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Dark Mode:</strong> Automatically adjusts with design system</span>
                                </li>
                            </ul>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Usage Example -->
                <Collapsible>
                    <CollapsibleTrigger
                        class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors"
                    >
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Examples
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold mb-2 text-sm">1. Basic Helper Text</h4>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;Label for="username"&gt;Username&lt;/Label&gt;
&lt;DashboardTextInput id="username" v-model="form.username" /&gt;
&lt;Hint text="Must be 3-20 characters, alphanumeric only" /&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-2 text-sm">2. Error Messages</h4>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;Label for="email" required&gt;Email&lt;/Label&gt;
&lt;DashboardTextInput
    id="email"
    v-model="form.email"
    :error="form.errors.email"
/&gt;
&lt;Hint v-if="form.errors.email" :text="form.errors.email" /&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-2 text-sm">3. Conditional Hints</h4>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;Label for="password"&gt;Password&lt;/Label&gt;
&lt;DashboardMaskedInput
    id="password"
    v-model="form.password"
    show-strength
/&gt;
&lt;Hint
    v-if="!form.password"
    text="Password must contain uppercase, lowercase, and numbers"
/&gt;
&lt;Hint
    v-else-if="passwordStrength === 'weak'"
    text="Try a stronger password"
/&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-2 text-sm">4. Informational Text</h4>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;Label for="avatar"&gt;Profile Picture&lt;/Label&gt;
&lt;FileUpload id="avatar" /&gt;
&lt;Hint text="Maximum file size: 2MB. Accepted formats: JPG, PNG" /&gt;</code></pre>
                            </div>
                        </div>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>

        <!-- ==================== Label ==================== -->
        <Card v-if="activeComponent === 'Label'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">Label (Enhanced)</CardTitle>
                        <CardDescription class="text-base mt-2">
                            Enhanced shadcn/ui Label with optional required indicator (red asterisk)
                        </CardDescription>
                    </div>
                    <Badge variant="secondary">Form Label</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="bg-muted/30 border-2 border-dashed rounded-lg p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <Eye class="h-5 w-5 text-primary" />
                        <h3 class="font-bold text-lg">Live Preview</h3>
                    </div>
                    <div class="bg-background rounded-lg p-6 space-y-6">
                        <div>
                            <Label for="demo-label-username">Username</Label>
                            <DashboardTextInput
                                id="demo-label-username"
                                v-model="demoForm.email"
                                placeholder="Enter username"
                                class="mt-2"
                            />
                            <Hint text="Optional field" class="mt-1" />
                        </div>
                        <div>
                            <Label for="demo-label-email" required>Email Address</Label>
                            <DashboardTextInput
                                id="demo-label-email"
                                v-model="demoForm.email"
                                type="email"
                                placeholder="your@email.com"
                                required
                                class="mt-2"
                            />
                            <Hint text="Required field with asterisk" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Import -->
                <div>
                    <h3 class="font-bold text-lg mb-3">📦 Import</h3>
                    <pre class="bg-muted p-4 rounded-lg text-sm"><code>import { Label } from '@ui/label';</code></pre>
                </div>

                <!-- Props Table -->
                <div>
                    <h3 class="font-bold text-lg mb-3">⚙️ Props</h3>
                    <div class="border rounded-lg overflow-hidden">
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
                                    <TableCell class="font-mono text-sm font-bold">for</TableCell>
                                    <TableCell>
                                        <Badge variant="default">string</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>
                                        <strong>✅ HTML for attribute - associates label with input by ID</strong>
                                    </TableCell>
                                </TableRow>
                                <TableRow class="bg-destructive/5">
                                    <TableCell class="font-mono text-sm font-bold">required</TableCell>
                                    <TableCell>
                                        <Badge variant="destructive">boolean</Badge>
                                    </TableCell>
                                    <TableCell><code>false</code></TableCell>
                                    <TableCell>
                                        <strong>⚠️ Shows red asterisk (*) after label text for required fields</strong>
                                    </TableCell>
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

                <!-- Styling Details -->
                <Collapsible>
                    <CollapsibleTrigger
                        class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors"
                    >
                        <ChevronDown class="h-5 w-5" />
                        🎨 Styling Details
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="border rounded-lg p-4">
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Font Size:</strong> Small (<code class="bg-muted px-1.5 py-0.5 rounded text-xs">text-sm</code>)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Font Weight:</strong> Medium (<code class="bg-muted px-1.5 py-0.5 rounded text-xs">font-medium</code>)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Asterisk Color:</strong> Destructive red (<code class="bg-muted px-1.5 py-0.5 rounded text-xs">text-destructive</code>)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Asterisk Spacing:</strong> Left margin (<code class="bg-muted px-1.5 py-0.5 rounded text-xs">ml-1</code>)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Dark Mode:</strong> Automatically adjusts with design system</span>
                                </li>
                            </ul>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Best Practices -->
                <Collapsible>
                    <CollapsibleTrigger
                        class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors"
                    >
                        <ChevronDown class="h-5 w-5" />
                        💡 Best Practices
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="border rounded-lg p-4">
                            <ul class="space-y-2 text-sm text-muted-foreground">
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span><strong>Always use `for` attribute</strong> to associate label with input</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span><strong>Use `required` prop</strong> for required fields (adds visual asterisk)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span><strong>Keep labels concise</strong> - use Hint component for longer explanations</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span><strong>Match label `for` with input `id`</strong> for proper accessibility</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500">✗</span>
                                    <span><strong>Don't add HTML `required` to label</strong> - use the `required` prop instead</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500">✗</span>
                                    <span><strong>Don't manually add asterisks</strong> - the prop handles this automatically</span>
                                </li>
                            </ul>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Usage Example -->
                <Collapsible>
                    <CollapsibleTrigger
                        class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors"
                    >
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Examples
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold mb-2 text-sm">1. Required Field</h4>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;Label for="email" required&gt;Email Address&lt;/Label&gt;
&lt;DashboardTextInput
    id="email"
    v-model="form.email"
    type="email"
    placeholder="your@email.com"
    :error="form.errors.email"
    required
/&gt;
&lt;Hint v-if="form.errors.email" :text="form.errors.email" /&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-2 text-sm">2. Optional Field</h4>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;Label for="phone"&gt;Phone Number (Optional)&lt;/Label&gt;
&lt;DashboardTextInput
    id="phone"
    v-model="form.phone"
    type="tel"
    placeholder="+1 (555) 123-4567"
/&gt;
&lt;Hint text="We'll only use this for account recovery" /&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-2 text-sm">3. Complete Form Field</h4>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;div class="space-y-2"&gt;
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
    &lt;Hint
        v-if="form.errors.password"
        :text="form.errors.password"
    /&gt;
    &lt;Hint
        v-else
        text="Minimum 8 characters with uppercase, lowercase, and numbers"
    /&gt;
&lt;/div&gt;</code></pre>
                            </div>
                        </div>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>

        <!-- ==================== InputError ==================== -->
        <Card v-if="activeComponent === 'InputError'" class="border-2">
            <CardHeader class="bg-primary/5">
                <div class="flex items-center justify-between">
                    <div>
                        <CardTitle class="text-2xl">InputError</CardTitle>
                        <CardDescription class="text-base mt-2">
                            Red error message text specifically for form validation errors
                        </CardDescription>
                    </div>
                    <Badge variant="secondary">Error Message</Badge>
                </div>
            </CardHeader>
            <CardContent class="space-y-8 pt-6">
                <!-- Live Preview -->
                <div class="bg-muted/30 border-2 border-dashed rounded-lg p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <Eye class="h-5 w-5 text-primary" />
                        <h3 class="font-bold text-lg">Live Preview</h3>
                    </div>
                    <div class="bg-background rounded-lg p-6 space-y-6">
                        <div>
                            <Label for="demo-error-email" required>Email Address</Label>
                            <DashboardTextInput
                                id="demo-error-email"
                                v-model="demoForm.email"
                                type="email"
                                placeholder="your@email.com"
                                :error="demoForm.errors.email"
                                class="mt-2"
                            />
                            <InputError :message="demoForm.errors.email" class="mt-1" />
                        </div>
                        <div>
                            <Label for="demo-error-password" required>Password</Label>
                            <DashboardTextInput
                                id="demo-error-password"
                                v-model="demoForm.password"
                                type="password"
                                placeholder="Enter password"
                                :error="demoForm.errors.password"
                                class="mt-2"
                            />
                            <InputError :message="demoForm.errors.password" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Import -->
                <div>
                    <h3 class="font-bold text-lg mb-3">📦 Import</h3>
                    <pre class="bg-muted p-4 rounded-lg text-sm"><code>import InputError from '@shared/components/InputError.vue';</code></pre>
                </div>

                <!-- Props Table -->
                <div>
                    <h3 class="font-bold text-lg mb-3">⚙️ Props</h3>
                    <div class="border rounded-lg overflow-hidden">
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
                                <TableRow class="bg-destructive/5">
                                    <TableCell class="font-mono text-sm font-bold">message</TableCell>
                                    <TableCell>
                                        <Badge variant="destructive">string | undefined</Badge>
                                    </TableCell>
                                    <TableCell><code>undefined</code></TableCell>
                                    <TableCell>
                                        <strong>⚠️ The error message to display. Hidden when undefined</strong>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>

                <!-- Styling Details -->
                <Collapsible>
                    <CollapsibleTrigger
                        class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors"
                    >
                        <ChevronDown class="h-5 w-5" />
                        🎨 Styling Details
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="border rounded-lg p-4">
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Font Size:</strong> Extra small (<code class="bg-muted px-1.5 py-0.5 rounded text-xs">text-xs</code>)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Color (Light):</strong> Red 600 (<code class="bg-muted px-1.5 py-0.5 rounded text-xs">text-red-600</code>)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Color (Dark):</strong> Red 500 (<code class="bg-muted px-1.5 py-0.5 rounded text-xs">dark:text-red-500</code>)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Visibility:</strong> Hidden with <code class="bg-muted px-1.5 py-0.5 rounded text-xs">v-show</code> when message is empty</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-primary">•</span>
                                    <span><strong>Tag:</strong> Paragraph (&lt;p&gt;) wrapped in div</span>
                                </li>
                            </ul>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Difference from Hint -->
                <Collapsible>
                    <CollapsibleTrigger
                        class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors"
                    >
                        <ChevronDown class="h-5 w-5" />
                        🔄 InputError vs Hint
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="border rounded-lg overflow-hidden">
                            <Table>
                                <TableHeader>
                                    <TableRow class="bg-muted/50">
                                        <TableHead class="font-bold">Feature</TableHead>
                                        <TableHead class="font-bold">InputError</TableHead>
                                        <TableHead class="font-bold">Hint</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow>
                                        <TableCell class="font-semibold">Purpose</TableCell>
                                        <TableCell>Show validation errors</TableCell>
                                        <TableCell>Show helpful hints</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-semibold">Color</TableCell>
                                        <TableCell class="text-red-600 dark:text-red-500">Red (destructive)</TableCell>
                                        <TableCell class="text-muted-foreground">Muted gray</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-semibold">When to use</TableCell>
                                        <TableCell>Form validation errors only</TableCell>
                                        <TableCell>Helper text, descriptions, tips</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-semibold">Visibility</TableCell>
                                        <TableCell>Uses <code>v-show</code> (stays in DOM)</TableCell>
                                        <TableCell>Always rendered if text provided</TableCell>
                                    </TableRow>
                                    <TableRow>
                                        <TableCell class="font-semibold">Prop name</TableCell>
                                        <TableCell><code>message</code></TableCell>
                                        <TableCell><code>text</code></TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Usage Example -->
                <Collapsible>
                    <CollapsibleTrigger
                        class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors"
                    >
                        <ChevronDown class="h-5 w-5" />
                        📝 Usage Examples
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold mb-2 text-sm">1. Basic Usage with Form Error</h4>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;Label for="email" required&gt;Email&lt;/Label&gt;
&lt;DashboardTextInput
    id="email"
    v-model="form.email"
    type="email"
    :error="form.errors.email"
/&gt;
&lt;InputError :message="form.errors.email" /&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-2 text-sm">2. Combined with Hint</h4>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;Label for="email" required&gt;Email&lt;/Label&gt;
&lt;DashboardTextInput
    id="email"
    v-model="form.email"
    type="email"
    :error="form.errors.email"
/&gt;
&lt;InputError :message="form.errors.email" /&gt;
&lt;Hint v-if="!form.errors.email" text="We'll never share your email" /&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-2 text-sm">3. Complete Form Field Pattern</h4>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;div class="space-y-2"&gt;
    &lt;Label for="password" required&gt;Password&lt;/Label&gt;
    &lt;DashboardMaskedInput
        id="password"
        v-model="form.password"
        placeholder="Enter password"
        :error="form.errors.password"
        toggle-mask
        show-strength
        required
    /&gt;
    &lt;InputError :message="form.errors.password" /&gt;
    &lt;Hint
        v-if="!form.errors.password"
        text="Minimum 8 characters with uppercase, lowercase, and numbers"
    /&gt;
&lt;/div&gt;</code></pre>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-2 text-sm">4. With Inertia Form</h4>
                                <pre class="bg-muted p-3 rounded text-sm overflow-x-auto"><code>&lt;script setup lang="ts"&gt;
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post('/login');
};
&lt;/script&gt;

&lt;template&gt;
    &lt;form @submit.prevent="submit" class="space-y-4"&gt;
        &lt;div class="space-y-2"&gt;
            &lt;Label for="email" required&gt;Email&lt;/Label&gt;
            &lt;DashboardTextInput
                id="email"
                v-model="form.email"
                type="email"
                :error="form.errors.email"
            /&gt;
            &lt;InputError :message="form.errors.email" /&gt;
        &lt;/div&gt;

        &lt;DashboardButton type="submit" :loading="form.processing"&gt;
            Login
        &lt;/DashboardButton&gt;
    &lt;/form&gt;
&lt;/template&gt;</code></pre>
                            </div>
                        </div>
                    </CollapsibleContent>
                </Collapsible>

                <!-- Best Practices -->
                <Collapsible>
                    <CollapsibleTrigger
                        class="flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors"
                    >
                        <ChevronDown class="h-5 w-5" />
                        💡 Best Practices
                    </CollapsibleTrigger>
                    <CollapsibleContent class="mt-3">
                        <div class="border rounded-lg p-4">
                            <ul class="space-y-2 text-sm text-muted-foreground">
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span><strong>Use for validation errors only</strong> - Don't use for general warnings or info</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span><strong>Always pair with input's error prop</strong> - Input should show red border when error exists</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span><strong>Place directly below the input</strong> - Error messages should be immediately visible</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span><strong>Use with Inertia form errors</strong> - Automatically works with <code class="bg-muted px-1.5 py-0.5 rounded text-xs">form.errors.fieldName</code></span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-500">✓</span>
                                    <span><strong>Combine with Hint conditionally</strong> - Show Hint when no error, InputError when error exists</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500">✗</span>
                                    <span><strong>Don't use for helper text</strong> - Use Hint component for non-error messages</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500">✗</span>
                                    <span><strong>Don't show when message is empty</strong> - Component handles this automatically with v-show</span>
                                </li>
                            </ul>
                        </div>
                    </CollapsibleContent>
                </Collapsible>
            </CardContent>
        </Card>
    </div>
</template>