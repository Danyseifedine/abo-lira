<script setup lang="ts">
import { ref } from 'vue';
import AdminLayout from '@modules/admin/layouts/AdminLayout.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@ui/card';
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';
import {
    BookOpen,
    Terminal,
    Palette,
    Package,
    Database,
    Shield,
    Settings,
    Boxes,
} from 'lucide-vue-next';
import FormsDoc from './components/Forms.vue';
import TypographyDoc from './components/Typography.vue';
import DataTableDoc from './components/DataTable.vue';

const activeTab = ref(0);
const componentSubTab = ref(0);

const sections = [
    { id: 'components', title: 'Components', icon: Boxes },
    { id: 'cli', title: 'CLI Commands', icon: Terminal },
    { id: 'styling', title: 'Styling', icon: Palette },
    { id: 'architecture', title: 'Architecture', icon: Package },
    { id: 'api', title: 'API', icon: BookOpen },
    { id: 'database', title: 'Database', icon: Database },
    { id: 'auth', title: 'Authentication', icon: Shield },
    { id: 'config', title: 'Configuration', icon: Settings },
];
</script>

<template>
    <AdminLayout>
        <div class="p-6">
            <div class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight">Documentation</h1>
                <p class="text-muted-foreground mt-2">
                    Developer reference for reusable components, patterns, and best practices
                </p>
            </div>

            <Tabs v-model="activeTab" value="0" class="w-full">
                <TabList class="mb-6">
                    <Tab
                        v-for="(section, index) in sections"
                        :key="section.id"
                        :value="index"
                        class="flex items-center gap-2"
                    >
                        <component :is="section.icon" class="h-4 w-4" />
                        {{ section.title }}
                    </Tab>
                </TabList>

                <TabPanels>
                    <!-- Components Tab with Sub-Tabs -->
                    <TabPanel :value="0">
                        <Tabs v-model="componentSubTab" value="0" class="w-full">
                            <TabList class="mb-4">
                                <Tab :value="0">DataTable</Tab>
                                <Tab :value="1">Forms</Tab>
                                <Tab :value="2">Typography</Tab>
                            </TabList>

                            <TabPanels>
                                <!-- DataTable Sub-Tab -->
                                <TabPanel :value="0">
                                    <DataTableDoc />
                                </TabPanel>

                                <!-- Forms Sub-Tab -->
                                <TabPanel :value="1">
                                    <FormsDoc />
                                </TabPanel>

                                <!-- Typography Sub-Tab -->
                                <TabPanel :value="2">
                                    <TypographyDoc />
                                </TabPanel>
                            </TabPanels>
                        </Tabs>
                    </TabPanel>

                    <!-- CLI Commands Tab -->
                    <TabPanel :value="1">
                        <div class="space-y-6">
                            <!-- Development -->
                            <Card>
                                <CardHeader>
                                    <CardTitle>Development</CardTitle>
                                </CardHeader>
                                <CardContent class="space-y-4">
                                    <div>
                                        <h4 class="font-semibold mb-2">Start Dev Server</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>composer run dev</code></pre>
                                        <p class="text-sm text-muted-foreground mt-2">
                                            Starts backend, queue worker, and Vite dev server
                                        </p>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold mb-2">With SSR</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>composer run dev:ssr</code></pre>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold mb-2">Individual Services</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>php artisan serve                    # Backend
php artisan queue:listen --tries=1   # Queue
npm run dev                          # Vite
php artisan inertia:start-ssr        # SSR</code></pre>
                                    </div>
                                </CardContent>
                            </Card>

                            <!-- Testing -->
                            <Card>
                                <CardHeader>
                                    <CardTitle>Testing</CardTitle>
                                </CardHeader>
                                <CardContent class="space-y-4">
                                    <div>
                                        <h4 class="font-semibold mb-2">Run All Tests</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>php artisan test</code></pre>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold mb-2">Run Specific Test</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>php artisan test tests/Feature/Auth/AuthenticationTest.php</code></pre>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold mb-2">Run Test Method</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>php artisan test --filter test_login_screen_can_be_rendered</code></pre>
                                    </div>
                                </CardContent>
                            </Card>

                            <!-- Code Quality -->
                            <Card>
                                <CardHeader>
                                    <CardTitle>Code Quality</CardTitle>
                                </CardHeader>
                                <CardContent class="space-y-4">
                                    <div>
                                        <h4 class="font-semibold mb-2">Format PHP (Pint)</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>vendor/bin/pint</code></pre>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold mb-2">Format JS/Vue/TS (Prettier)</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>npm run format</code></pre>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold mb-2">Lint</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>npm run lint</code></pre>
                                    </div>
                                </CardContent>
                            </Card>

                            <!-- Database -->
                            <Card>
                                <CardHeader>
                                    <CardTitle>Database</CardTitle>
                                </CardHeader>
                                <CardContent class="space-y-4">
                                    <div>
                                        <h4 class="font-semibold mb-2">Run Migrations</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>php artisan migrate</code></pre>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold mb-2">Fresh Migration with Seed</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>php artisan migrate:fresh --seed</code></pre>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold mb-2">Create Model with Files</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>php artisan make:model Post -mfs</code></pre>
                                        <p class="text-sm text-muted-foreground mt-2">
                                            -m = migration, -f = factory, -s = seeder
                                        </p>
                                    </div>
                                </CardContent>
                            </Card>

                            <!-- Build -->
                            <Card>
                                <CardHeader>
                                    <CardTitle>Build</CardTitle>
                                </CardHeader>
                                <CardContent class="space-y-4">
                                    <div>
                                        <h4 class="font-semibold mb-2">Build Frontend</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>npm run build</code></pre>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold mb-2">Build with SSR</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>npm run build:ssr</code></pre>
                                    </div>
                                </CardContent>
                            </Card>

                            <!-- Utilities -->
                            <Card>
                                <CardHeader>
                                    <CardTitle>Utilities</CardTitle>
                                </CardHeader>
                                <CardContent class="space-y-4">
                                    <div>
                                        <h4 class="font-semibold mb-2">Clear Caches</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>php artisan optimize:clear</code></pre>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold mb-2">View Routes</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>php artisan route:list</code></pre>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold mb-2">Watch Logs</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>php artisan pail</code></pre>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold mb-2">Generate IDE Helpers</h4>
                                        <pre
                                            class="bg-muted p-4 rounded-lg overflow-x-auto text-sm"
                                        ><code>php artisan ide-helper:generate
php artisan ide-helper:models</code></pre>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                    </TabPanel>

                    <!-- Styling Tab -->
                    <TabPanel :value="2">
                        <Card>
                            <CardHeader>
                                <CardTitle>Styling Guidelines</CardTitle>
                                <CardDescription>Coming soon...</CardDescription>
                            </CardHeader>
                        </Card>
                    </TabPanel>

                    <!-- Architecture Tab -->
                    <TabPanel :value="3">
                        <Card>
                            <CardHeader>
                                <CardTitle>Architecture Overview</CardTitle>
                                <CardDescription>Coming soon...</CardDescription>
                            </CardHeader>
                        </Card>
                    </TabPanel>

                    <!-- API Tab -->
                    <TabPanel :value="4">
                        <Card>
                            <CardHeader>
                                <CardTitle>API Documentation</CardTitle>
                                <CardDescription>Coming soon...</CardDescription>
                            </CardHeader>
                        </Card>
                    </TabPanel>

                    <!-- Database Tab -->
                    <TabPanel :value="5">
                        <Card>
                            <CardHeader>
                                <CardTitle>Database Schema</CardTitle>
                                <CardDescription>Coming soon...</CardDescription>
                            </CardHeader>
                        </Card>
                    </TabPanel>

                    <!-- Authentication Tab -->
                    <TabPanel :value="6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Authentication & Authorization</CardTitle>
                                <CardDescription>Coming soon...</CardDescription>
                            </CardHeader>
                        </Card>
                    </TabPanel>

                    <!-- Configuration Tab -->
                    <TabPanel :value="7">
                        <Card>
                            <CardHeader>
                                <CardTitle>Configuration</CardTitle>
                                <CardDescription>Coming soon...</CardDescription>
                            </CardHeader>
                        </Card>
                    </TabPanel>
                </TabPanels>
            </Tabs>
        </div>
    </AdminLayout>
</template>
