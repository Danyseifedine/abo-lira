import{_ as p}from"./Card.vue_vue_type_script_setup_true_lang-D5CuwiOU.js";import{_ as b,a as g,c as D,b as x}from"./CardTitle.vue_vue_type_script_setup_true_lang-fRk2Fftf.js";import{_ as r}from"./index-Dpga1Y21.js";import{_ as i,a as f,b as a,c as d,d as m,e as s,f as v,C as y,g as C}from"./TableHeader.vue_vue_type_script_setup_true_lang-BkpxOicn.js";import{_ as w}from"./CollapsibleTrigger.vue_vue_type_script_setup_true_lang-Dj46wTA9.js";import{d as k,c as T,o as S,a as t,w as n,u as e,g as u,b as o}from"./app-BLvqcGW3.js";const U={class:"space-y-6"},R=k({__name:"DataTable",setup(P){return(E,l)=>(S(),T("div",U,[t(e(p),null,{default:n(()=>[t(e(b),null,{default:n(()=>[t(e(g),null,{default:n(()=>[...l[0]||(l[0]=[u("DataTable Component",-1)])]),_:1}),t(e(D),null,{default:n(()=>[...l[1]||(l[1]=[u(" A powerful, feature-rich data table component built on TanStack Vue Table with server-side and client-side support. ",-1)])]),_:1})]),_:1}),t(e(x),{class:"space-y-4"},{default:n(()=>[...l[2]||(l[2]=[o("div",{class:"border-l-4 border-primary pl-4"},[o("h4",{class:"font-semibold mb-2"},"✨ Key Features"),o("ul",{class:"space-y-1 text-sm text-muted-foreground"},[o("li",null,"• Server-side & client-side pagination"),o("li",null,"• Multi-column search with debouncing"),o("li",null,"• Flexible filtering system"),o("li",null,"• Column sorting & visibility toggles"),o("li",null,"• Row selection with bulk actions"),o("li",null,"• Customizable column types (text, badge, date, toggle, actions)"),o("li",null,"• Built-in integration with Laravel backend via HasDataTable trait"),o("li",null,"• Full TypeScript support")])],-1)])]),_:1})]),_:1}),t(e(p),null,{default:n(()=>[t(e(b),null,{default:n(()=>[t(e(g),null,{default:n(()=>[...l[3]||(l[3]=[u("📐 Architecture",-1)])]),_:1})]),_:1}),t(e(x),{class:"space-y-4"},{default:n(()=>[...l[4]||(l[4]=[o("div",{class:"grid grid-cols-1 md:grid-cols-3 gap-4"},[o("div",{class:"border rounded-lg p-4 bg-blue-500/5"},[o("h4",{class:"font-semibold text-sm mb-2"},"1. Backend (Laravel)"),o("ul",{class:"text-xs space-y-1 text-muted-foreground"},[o("li",null,[u("• "),o("code",null,"HasDataTable"),u(" trait")]),o("li",null,"• Service layer config"),o("li",null,"• Controller orchestration")])]),o("div",{class:"border rounded-lg p-4 bg-green-500/5"},[o("h4",{class:"font-semibold text-sm mb-2"},"2. Frontend (Vue)"),o("ul",{class:"text-xs space-y-1 text-muted-foreground"},[o("li",null,"• DataTable component"),o("li",null,"• Column definitions"),o("li",null,"• Type interfaces")])]),o("div",{class:"border rounded-lg p-4 bg-purple-500/5"},[o("h4",{class:"font-semibold text-sm mb-2"},"3. State Management"),o("ul",{class:"text-xs space-y-1 text-muted-foreground"},[o("li",null,[u("• "),o("code",null,"useDatatable"),u(" composable")]),o("li",null,[u("• "),o("code",null,"useFilters"),u(" composable")]),o("li",null,"• TanStack Vue Table")])])],-1)])]),_:1})]),_:1}),t(e(p),null,{default:n(()=>[t(e(b),null,{default:n(()=>[t(e(g),null,{default:n(()=>[...l[5]||(l[5]=[u("🚀 Basic Usage",-1)])]),_:1})]),_:1}),t(e(x),{class:"space-y-4"},{default:n(()=>[...l[6]||(l[6]=[o("pre",{class:"bg-muted p-4 rounded-lg overflow-x-auto text-sm"},[o("code",null,`<script setup lang="ts">
import DataTable from '@/common/components/dashboards/datatable/Datatable.vue';
import { userColumns } from './datatable/userColumns';
import type { User } from './datatable/type';

const props = defineProps<{
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
}>();

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

const handleRowClick = (user: User) => {
    router.get(route('super-admin.users.show', user.id));
};
<\/script>

<template>
    <DataTable
        :columns="userColumns"
        :data="users.data"
        :config="tableConfig"
        @row-click="handleRowClick"
    >
        <!-- Optional: Custom toolbar actions -->
        <template #toolbar="{ table }">
            <Button v-if="table.getFilteredSelectedRowModel().rows.length > 0">
                Delete ({ { table.getFilteredSelectedRowModel().rows.length } })
            </Button>
        </template>

        <!-- Optional: Custom filters -->
        <template #filters>
            <DashboardSelect v-model="localFilters.role" :options="roles" />
        </template>
    </DataTable>
</template>`)],-1)])]),_:1})]),_:1}),t(e(p),null,{default:n(()=>[t(e(b),null,{default:n(()=>[t(e(g),null,{default:n(()=>[...l[7]||(l[7]=[u("⚙️ Configuration Options",-1)])]),_:1})]),_:1}),t(e(x),null,{default:n(()=>[t(e(i),null,{default:n(()=>[t(e(f),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(d),{class:"w-[200px]"},{default:n(()=>[...l[8]||(l[8]=[u("Property",-1)])]),_:1}),t(e(d),{class:"w-[150px]"},{default:n(()=>[...l[9]||(l[9]=[u("Type",-1)])]),_:1}),t(e(d),{class:"w-[120px]"},{default:n(()=>[...l[10]||(l[10]=[u("Default",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[11]||(l[11]=[u("Description",-1)])]),_:1})]),_:1})]),_:1}),t(e(m),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[12]||(l[12]=[u("searchable",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[13]||(l[13]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[14]||(l[14]=[o("code",null,"true",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[15]||(l[15]=[u("Enable search functionality",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[16]||(l[16]=[u("searchPlaceholder",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[17]||(l[17]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[18]||(l[18]=[o("code",null,'"Search..."',-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[19]||(l[19]=[u("Placeholder text for search input",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[20]||(l[20]=[u("selectable",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[21]||(l[21]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[22]||(l[22]=[o("code",null,"true",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[23]||(l[23]=[u("Enable row selection with checkboxes",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[24]||(l[24]=[u("columnVisibility",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[25]||(l[25]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[26]||(l[26]=[o("code",null,"true",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[27]||(l[27]=[u("Enable column visibility toggle",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[28]||(l[28]=[u("perPageSelector",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[29]||(l[29]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[30]||(l[30]=[o("code",null,"true",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[31]||(l[31]=[u("Enable per-page dropdown selector",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[32]||(l[32]=[u("perPageOptions",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[33]||(l[33]=[u("number[]",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[34]||(l[34]=[o("code",null,"[10, 20, 30, 50, 100]",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[35]||(l[35]=[u("Options for per-page selector",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[36]||(l[36]=[u("filterable",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[37]||(l[37]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[38]||(l[38]=[o("code",null,"false",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[39]||(l[39]=[u("Enable filter panel",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[40]||(l[40]=[u("serverSide",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[41]||(l[41]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[42]||(l[42]=[o("code",null,"false",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[43]||(l[43]=[u("Use server-side pagination/sorting",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[44]||(l[44]=[u("pagination",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[45]||(l[45]=[u("PaginationData",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[46]||(l[46]=[o("code",null,"undefined",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[47]||(l[47]=[u("Server pagination data (required if serverSide: true)",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[48]||(l[48]=[u("filters",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[49]||(l[49]=[u("FilterData",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[50]||(l[50]=[o("code",null,"undefined",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[51]||(l[51]=[u("Current filter state",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[52]||(l[52]=[u("routeName",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[53]||(l[53]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[54]||(l[54]=[o("code",null,"undefined",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[55]||(l[55]=[u("Inertia route name for navigation",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[56]||(l[56]=[u("preserveState",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[57]||(l[57]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[58]||(l[58]=[o("code",null,"false",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[59]||(l[59]=[u("Preserve component state on navigation",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[60]||(l[60]=[u("preserveScroll",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[61]||(l[61]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[62]||(l[62]=[o("code",null,"true",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[63]||(l[63]=[u("Preserve scroll position on navigation",-1)])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),t(e(p),null,{default:n(()=>[t(e(b),null,{default:n(()=>[t(e(g),null,{default:n(()=>[...l[64]||(l[64]=[u("📋 Column Types",-1)])]),_:1}),t(e(D),null,{default:n(()=>[...l[65]||(l[65]=[u(" All available column types and their configurations ",-1)])]),_:1})]),_:1}),t(e(x),{class:"space-y-6"},{default:n(()=>[l[307]||(l[307]=o("div",{class:"border-l-4 border-primary pl-4 bg-primary/5 p-3 rounded"},[o("h4",{class:"font-semibold mb-2 text-sm"},"📦 Available Column Types"),o("div",{class:"grid grid-cols-2 md:grid-cols-3 gap-2 text-sm"},[o("code",{class:"bg-muted px-2 py-1 rounded"},"textColumn()"),o("code",{class:"bg-muted px-2 py-1 rounded"},"badgeColumn()"),o("code",{class:"bg-muted px-2 py-1 rounded"},"dateColumn()"),o("code",{class:"bg-muted px-2 py-1 rounded"},"toggleColumn()"),o("code",{class:"bg-muted px-2 py-1 rounded"},"counterColumn()"),o("code",{class:"bg-muted px-2 py-1 rounded"},"selectColumn()"),o("code",{class:"bg-muted px-2 py-1 rounded"},"actionsColumn()"),o("code",{class:"bg-green-500/20 px-2 py-1 rounded font-semibold"},"imageColumn() 🆕"),o("code",{class:"bg-green-500/20 px-2 py-1 rounded font-semibold"},"linkColumn() 🆕"),o("code",{class:"bg-muted px-2 py-1 rounded"},"customColumn()")]),o("p",{class:"text-xs text-muted-foreground mt-2"},[u(" Import from: "),o("code",null,"@/common/components/dashboards/datatable/columnDef")])],-1)),t(e(v),null,{default:n(()=>[t(e(w),{class:"flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full"},{default:n(()=>[t(e(y),{class:"h-5 w-5"}),l[67]||(l[67]=o("span",null,"textColumn",-1)),t(e(r),{variant:"secondary",class:"ml-2"},{default:n(()=>[...l[66]||(l[66]=[u("Text",-1)])]),_:1})]),_:1}),t(e(C),{class:"mt-3 space-y-4"},{default:n(()=>[l[109]||(l[109]=o("p",{class:"text-sm text-muted-foreground"}," Display text content with optional formatting and sorting. ",-1)),l[110]||(l[110]=o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"Usage Example"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`import { textColumn } from '@/common/components/dashboards/datatable/columnDef';

textColumn('name', 'Full Name', {
    sortable: true,
    searchable: true,
    visible: true,
    className: 'font-medium',
    format: (value) => value?.toUpperCase() || 'N/A',
})`)])],-1)),o("div",null,[l[108]||(l[108]=o("h4",{class:"font-semibold mb-2 text-sm"},"Properties",-1)),t(e(i),null,{default:n(()=>[t(e(f),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(d),null,{default:n(()=>[...l[68]||(l[68]=[u("Property",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[69]||(l[69]=[u("Type",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[70]||(l[70]=[u("Default",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[71]||(l[71]=[u("Description",-1)])]),_:1})]),_:1})]),_:1}),t(e(m),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[72]||(l[72]=[u("key",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[73]||(l[73]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[74]||(l[74]=[o("span",{class:"text-red-500"},"required",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[75]||(l[75]=[u("Data property key (e.g., 'name', 'email')",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[76]||(l[76]=[u("label",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[77]||(l[77]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[78]||(l[78]=[o("code",null,"key",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[79]||(l[79]=[u("Column header label",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[80]||(l[80]=[u("sortable",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[81]||(l[81]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[82]||(l[82]=[o("code",null,"true",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[83]||(l[83]=[u("Enable column sorting",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[84]||(l[84]=[u("searchable",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[85]||(l[85]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[86]||(l[86]=[o("code",null,"false",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[87]||(l[87]=[u("Include in global search (backend only)",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[88]||(l[88]=[u("visible",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[89]||(l[89]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[90]||(l[90]=[o("code",null,"true",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[91]||(l[91]=[u("Initial visibility state",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[92]||(l[92]=[u("className",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[93]||(l[93]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[94]||(l[94]=[o("code",null,"undefined",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[95]||(l[95]=[u("CSS classes for cell content",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[96]||(l[96]=[u("headerClassName",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[97]||(l[97]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[98]||(l[98]=[o("code",null,"undefined",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[99]||(l[99]=[u("CSS classes for header",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[100]||(l[100]=[u("width",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[101]||(l[101]=[u("number | string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[102]||(l[102]=[o("code",null,"undefined",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[103]||(l[103]=[u("Fixed column width (e.g., 200, '200px')",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[104]||(l[104]=[u("format",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[105]||(l[105]=[u("(value: any) => string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[106]||(l[106]=[o("code",null,"undefined",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[107]||(l[107]=[u("Custom formatter function",-1)])]),_:1})]),_:1})]),_:1})]),_:1})])]),_:1})]),_:1}),t(e(v),null,{default:n(()=>[t(e(w),{class:"flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full"},{default:n(()=>[t(e(y),{class:"h-5 w-5"}),l[112]||(l[112]=o("span",null,"badgeColumn",-1)),t(e(r),{variant:"secondary",class:"ml-2"},{default:n(()=>[...l[111]||(l[111]=[u("Badge",-1)])]),_:1})]),_:1}),t(e(C),{class:"mt-3 space-y-4"},{default:n(()=>[l[138]||(l[138]=o("p",{class:"text-sm text-muted-foreground"}," Display data as styled badges with custom variants. Supports single badges or multiple badges for arrays. ",-1)),l[139]||(l[139]=o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"Usage Example"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`import { badgeColumn } from '@/common/components/dashboards/datatable/columnDef';

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
})`)])],-1)),o("div",null,[l[137]||(l[137]=o("h4",{class:"font-semibold mb-2 text-sm"},"Properties",-1)),t(e(i),null,{default:n(()=>[t(e(f),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(d),null,{default:n(()=>[...l[113]||(l[113]=[u("Property",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[114]||(l[114]=[u("Type",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[115]||(l[115]=[u("Default",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[116]||(l[116]=[u("Description",-1)])]),_:1})]),_:1})]),_:1}),t(e(m),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[117]||(l[117]=[u("key",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[118]||(l[118]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[119]||(l[119]=[o("span",{class:"text-red-500"},"required",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[120]||(l[120]=[u("Data property key",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[121]||(l[121]=[u("label",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[122]||(l[122]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[123]||(l[123]=[o("code",null,"key",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[124]||(l[124]=[u("Column header label",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[125]||(l[125]=[u("variants",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[126]||(l[126]=[u("Record<string, string>",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[127]||(l[127]=[o("code",null,"{}",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[128]||(l[128]=[u("Map values to badge variants (default, secondary, destructive, outline)",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[129]||(l[129]=[u("defaultVariant",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[130]||(l[130]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[131]||(l[131]=[o("code",null,"'default'",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[132]||(l[132]=[u("Fallback variant if value not in variants map",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[133]||(l[133]=[u("multiple",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[134]||(l[134]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[135]||(l[135]=[o("code",null,"false",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[136]||(l[136]=[u("Display multiple badges for array values",-1)])]),_:1})]),_:1})]),_:1})]),_:1})])]),_:1})]),_:1}),t(e(v),null,{default:n(()=>[t(e(w),{class:"flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full"},{default:n(()=>[t(e(y),{class:"h-5 w-5"}),l[141]||(l[141]=o("span",null,"dateColumn",-1)),t(e(r),{variant:"secondary",class:"ml-2"},{default:n(()=>[...l[140]||(l[140]=[u("Date",-1)])]),_:1})]),_:1}),t(e(C),{class:"mt-3 space-y-4"},{default:n(()=>[l[167]||(l[167]=o("p",{class:"text-sm text-muted-foreground"},' Display dates with custom formatting or relative time (e.g., "2 days ago"). ',-1)),l[168]||(l[168]=o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"Usage Example"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`import { dateColumn } from '@/common/components/dashboards/datatable/columnDef';

// Relative time format
dateColumn('created_at', 'Created', {
    relative: true,
    sortable: true,
})

// Custom date format
dateColumn('updated_at', 'Updated', {
    format: 'MMM DD, YYYY',
    sortable: true,
})`)])],-1)),o("div",null,[l[166]||(l[166]=o("h4",{class:"font-semibold mb-2 text-sm"},"Properties",-1)),t(e(i),null,{default:n(()=>[t(e(f),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(d),null,{default:n(()=>[...l[142]||(l[142]=[u("Property",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[143]||(l[143]=[u("Type",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[144]||(l[144]=[u("Default",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[145]||(l[145]=[u("Description",-1)])]),_:1})]),_:1})]),_:1}),t(e(m),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[146]||(l[146]=[u("key",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[147]||(l[147]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[148]||(l[148]=[o("span",{class:"text-red-500"},"required",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[149]||(l[149]=[u("Data property key",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[150]||(l[150]=[u("label",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[151]||(l[151]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[152]||(l[152]=[o("code",null,"key",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[153]||(l[153]=[u("Column header label",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[154]||(l[154]=[u("sortable",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[155]||(l[155]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[156]||(l[156]=[o("code",null,"true",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[157]||(l[157]=[u("Enable column sorting",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[158]||(l[158]=[u("relative",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[159]||(l[159]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[160]||(l[160]=[o("code",null,"false",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[161]||(l[161]=[u('Display relative time (e.g., "2 hours ago")',-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[162]||(l[162]=[u("format",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[163]||(l[163]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[164]||(l[164]=[o("code",null,"'MMM DD, YYYY'",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[165]||(l[165]=[u("Date format string (ignored if relative: true)",-1)])]),_:1})]),_:1})]),_:1})]),_:1})])]),_:1})]),_:1}),t(e(v),null,{default:n(()=>[t(e(w),{class:"flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full"},{default:n(()=>[t(e(y),{class:"h-5 w-5"}),l[170]||(l[170]=o("span",null,"toggleColumn",-1)),t(e(r),{variant:"secondary",class:"ml-2"},{default:n(()=>[...l[169]||(l[169]=[u("Toggle",-1)])]),_:1})]),_:1}),t(e(C),{class:"mt-3 space-y-4"},{default:n(()=>[l[200]||(l[200]=o("p",{class:"text-sm text-muted-foreground"}," Interactive toggle switch with callback support and conditional disabling. ",-1)),l[201]||(l[201]=o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"Usage Example"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`import { toggleColumn } from '@/common/components/dashboards/datatable/columnDef';
import { router } from '@inertiajs/vue3';

toggleColumn('is_active', 'Active', {
    onToggle: (value: boolean, user: User, control) => {
        router.patch(route('super-admin.users.toggle-status', user.id),
            { is_active: value },
            {
                preserveScroll: true,
                onSuccess: (page) => {
                    const response = page.props.flash?.toast;
                    if (response?.success === false) {
                        control.revert(); // Revert toggle on error
                    }
                }
            }
        );
    },
    disabled: (user: User) => {
        return user.role === 'super-admin';
    },
    toggledWhen: (value: any) => {
        return convertToBoolean(value);
    },
    size: 'sm',
    className: 'flex justify-center',
})`)])],-1)),o("div",null,[l[199]||(l[199]=o("h4",{class:"font-semibold mb-2 text-sm"},"Properties",-1)),t(e(i),null,{default:n(()=>[t(e(f),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(d),null,{default:n(()=>[...l[171]||(l[171]=[u("Property",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[172]||(l[172]=[u("Type",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[173]||(l[173]=[u("Default",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[174]||(l[174]=[u("Description",-1)])]),_:1})]),_:1})]),_:1}),t(e(m),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[175]||(l[175]=[u("key",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[176]||(l[176]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[177]||(l[177]=[o("span",{class:"text-red-500"},"required",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[178]||(l[178]=[u("Data property key",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[179]||(l[179]=[u("label",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[180]||(l[180]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[181]||(l[181]=[o("code",null,"key",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[182]||(l[182]=[u("Column header label",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[183]||(l[183]=[u("onToggle",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[184]||(l[184]=[u("(value, row, control) => void",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[185]||(l[185]=[o("code",null,"undefined",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[186]||(l[186]=[u("Callback when toggle is clicked. Receives new value, row data, and control object",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[187]||(l[187]=[u("disabled",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[188]||(l[188]=[u("(row) => boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[189]||(l[189]=[o("code",null,"undefined",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[190]||(l[190]=[u("Function to determine if toggle should be disabled",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[191]||(l[191]=[u("toggledWhen",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[192]||(l[192]=[u("(value, row) => boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[193]||(l[193]=[o("code",null,"undefined",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[194]||(l[194]=[u("Custom logic to determine toggle state",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[195]||(l[195]=[u("size",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[196]||(l[196]=[u("'sm' | 'default' | 'lg'",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[197]||(l[197]=[o("code",null,"'default'",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[198]||(l[198]=[u("Toggle switch size",-1)])]),_:1})]),_:1})]),_:1})]),_:1})]),l[202]||(l[202]=o("div",{class:"border-l-4 border-blue-500 pl-4 bg-blue-500/5 p-3 rounded"},[o("h5",{class:"font-semibold text-sm mb-2"},"🎛️ Control Object"),o("p",{class:"text-xs text-muted-foreground mb-2"},"The control object passed to onToggle provides:"),o("ul",{class:"text-xs space-y-1"},[o("li",null,[u("• "),o("code",null,"control.revert()"),u(" - Revert toggle to previous state")]),o("li",null,[u("• "),o("code",null,"control.toggle()"),u(" - Programmatically toggle")]),o("li",null,[u("• "),o("code",null,"control.dontToggle()"),u(" - Prevent toggle action")])])],-1))]),_:1})]),_:1}),t(e(v),null,{default:n(()=>[t(e(w),{class:"flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full"},{default:n(()=>[t(e(y),{class:"h-5 w-5"}),l[204]||(l[204]=o("span",null,"counterColumn",-1)),t(e(r),{variant:"secondary",class:"ml-2"},{default:n(()=>[...l[203]||(l[203]=[u("Counter",-1)])]),_:1})]),_:1}),t(e(C),{class:"mt-3 space-y-4"},{default:n(()=>[l[218]||(l[218]=o("p",{class:"text-sm text-muted-foreground"}," Display auto-incrementing row numbers. ",-1)),l[219]||(l[219]=o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"Usage Example"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`import { counterColumn } from '@/common/components/dashboards/datatable/columnDef';

counterColumn('#', {
    startFrom: 1,
})`)])],-1)),o("div",null,[l[217]||(l[217]=o("h4",{class:"font-semibold mb-2 text-sm"},"Properties",-1)),t(e(i),null,{default:n(()=>[t(e(f),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(d),null,{default:n(()=>[...l[205]||(l[205]=[u("Property",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[206]||(l[206]=[u("Type",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[207]||(l[207]=[u("Default",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[208]||(l[208]=[u("Description",-1)])]),_:1})]),_:1})]),_:1}),t(e(m),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[209]||(l[209]=[u("label",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[210]||(l[210]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[211]||(l[211]=[o("code",null,"'#'",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[212]||(l[212]=[u("Column header label",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[213]||(l[213]=[u("startFrom",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[214]||(l[214]=[u("number",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[215]||(l[215]=[o("code",null,"1",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[216]||(l[216]=[u("Starting number for counter",-1)])]),_:1})]),_:1})]),_:1})]),_:1})])]),_:1})]),_:1}),t(e(v),null,{default:n(()=>[t(e(w),{class:"flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full"},{default:n(()=>[t(e(y),{class:"h-5 w-5"}),l[221]||(l[221]=o("span",null,"selectColumn",-1)),t(e(r),{variant:"secondary",class:"ml-2"},{default:n(()=>[...l[220]||(l[220]=[u("Checkbox",-1)])]),_:1})]),_:1}),t(e(C),{class:"mt-3 space-y-4"},{default:n(()=>[...l[222]||(l[222]=[o("p",{class:"text-sm text-muted-foreground"},' Display checkboxes for row selection with "select all" functionality. ',-1),o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"Usage Example"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`import { selectColumn } from '@/common/components/dashboards/datatable/columnDef';

selectColumn() // No configuration needed`)])],-1),o("div",{class:"border-l-4 border-blue-500 pl-4 bg-blue-500/5 p-3 rounded"},[o("h5",{class:"font-semibold text-sm mb-2"},"💡 Note"),o("p",{class:"text-xs text-muted-foreground"},[u(" Use "),o("code",null,"counterColumn()"),u(" for row numbers or "),o("code",null,"selectColumn()"),u(" for checkboxes - they occupy the same position. ")])],-1)])]),_:1})]),_:1}),t(e(v),null,{default:n(()=>[t(e(w),{class:"flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full"},{default:n(()=>[t(e(y),{class:"h-5 w-5"}),l[224]||(l[224]=o("span",null,"actionsColumn",-1)),t(e(r),{variant:"secondary",class:"ml-2"},{default:n(()=>[...l[223]||(l[223]=[u("Actions",-1)])]),_:1})]),_:1}),t(e(C),{class:"mt-3 space-y-4"},{default:n(()=>[l[258]||(l[258]=o("p",{class:"text-sm text-muted-foreground"}," Dropdown menu with action items (view, edit, delete, etc.) with icons and conditional visibility. ",-1)),l[259]||(l[259]=o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"Usage Example"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`import { actionsColumn } from '@/common/components/dashboards/datatable/columnDef';
import { Copy, Eye, Edit, Trash2 } from 'lucide-vue-next';

actionsColumn([
    {
        label: 'Copy ID',
        icon: Copy,
        onClick: (user) => {
            navigator.clipboard.writeText(user.id.toString());
        },
    },
    { separator: true, label: 'Separator' },
    {
        label: 'View',
        icon: Eye,
        href: (user) => route('super-admin.users.show', user.id),
    },
    {
        label: 'Edit',
        icon: Edit,
        href: (user) => route('super-admin.users.edit', user.id),
    },
    { separator: true, label: 'Separator' },
    {
        label: 'Delete',
        icon: Trash2,
        destructive: true,
        show: (user) => user.role !== 'super-admin',
        onClick: (user) => {
            openDeleteDialog(user);
        },
    },
])`)])],-1)),o("div",null,[l[257]||(l[257]=o("h4",{class:"font-semibold mb-2 text-sm"},"Action Item Properties",-1)),t(e(i),null,{default:n(()=>[t(e(f),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(d),null,{default:n(()=>[...l[225]||(l[225]=[u("Property",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[226]||(l[226]=[u("Type",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[227]||(l[227]=[u("Required",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[228]||(l[228]=[u("Description",-1)])]),_:1})]),_:1})]),_:1}),t(e(m),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[229]||(l[229]=[u("label",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[230]||(l[230]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"destructive"},{default:n(()=>[...l[231]||(l[231]=[u("Yes",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[232]||(l[232]=[u("Action label text",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[233]||(l[233]=[u("icon",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[234]||(l[234]=[u("Component",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"secondary"},{default:n(()=>[...l[235]||(l[235]=[u("No",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[236]||(l[236]=[u("Lucide icon component",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[237]||(l[237]=[u("onClick",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[238]||(l[238]=[u("(row) => void",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"secondary"},{default:n(()=>[...l[239]||(l[239]=[u("No",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[240]||(l[240]=[u("Click handler function",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[241]||(l[241]=[u("href",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[242]||(l[242]=[u("(row) => string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"secondary"},{default:n(()=>[...l[243]||(l[243]=[u("No",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[244]||(l[244]=[u("Inertia navigation URL",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[245]||(l[245]=[u("show",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[246]||(l[246]=[u("(row) => boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"secondary"},{default:n(()=>[...l[247]||(l[247]=[u("No",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[248]||(l[248]=[u("Conditional visibility",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[249]||(l[249]=[u("destructive",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[250]||(l[250]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"secondary"},{default:n(()=>[...l[251]||(l[251]=[u("No",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[252]||(l[252]=[u("Apply destructive styling (red)",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[253]||(l[253]=[u("separator",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[254]||(l[254]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"secondary"},{default:n(()=>[...l[255]||(l[255]=[u("No",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[256]||(l[256]=[u("Render as separator line",-1)])]),_:1})]),_:1})]),_:1})]),_:1})])]),_:1})]),_:1}),t(e(v),null,{default:n(()=>[t(e(w),{class:"flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full"},{default:n(()=>[t(e(y),{class:"h-5 w-5"}),l[261]||(l[261]=o("span",null,"imageColumn",-1)),t(e(r),{variant:"secondary",class:"ml-2"},{default:n(()=>[...l[260]||(l[260]=[u("Image",-1)])]),_:1})]),_:1}),t(e(C),{class:"mt-3 space-y-4"},{default:n(()=>[l[283]||(l[283]=o("p",{class:"text-sm text-muted-foreground"}," Display images with automatic fallback, customizable size and shape. Perfect for avatars and thumbnails. ",-1)),l[284]||(l[284]=o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"Usage Example"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`import { imageColumn } from '@/common/components/dashboards/datatable/columnDef';

// Basic usage
imageColumn('avatar', 'Photo')

// With options
imageColumn('avatar', 'Photo', {
    fallback: '/images/default-avatar.png',
    size: 'lg',
    shape: 'circle',
    alt: (user) => user.name,
    sortable: false
})`)])],-1)),o("div",null,[l[282]||(l[282]=o("h4",{class:"font-semibold mb-2 text-sm"},"Properties",-1)),t(e(i),null,{default:n(()=>[t(e(f),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(d),null,{default:n(()=>[...l[262]||(l[262]=[u("Property",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[263]||(l[263]=[u("Type",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[264]||(l[264]=[u("Default",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[265]||(l[265]=[u("Description",-1)])]),_:1})]),_:1})]),_:1}),t(e(m),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[266]||(l[266]=[u("fallback",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[267]||(l[267]=[u("string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[268]||(l[268]=[o("code",null,"'/images/default-avatar.png'",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[269]||(l[269]=[u("Fallback image when value is null or fails to load",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[270]||(l[270]=[u("size",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[271]||(l[271]=[u("'sm' | 'md' | 'lg'",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[272]||(l[272]=[o("code",null,"'md'",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[273]||(l[273]=[u("Image size (sm: 32px, md: 40px, lg: 64px)",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[274]||(l[274]=[u("shape",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[275]||(l[275]=[u("'circle' | 'square' | 'rounded'",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[276]||(l[276]=[o("code",null,"'circle'",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[277]||(l[277]=[u("Image shape style",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[278]||(l[278]=[u("alt",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[279]||(l[279]=[u("(row) => string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[280]||(l[280]=[o("code",null,"label",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[281]||(l[281]=[u("Alt text function for accessibility",-1)])]),_:1})]),_:1})]),_:1})]),_:1})])]),_:1})]),_:1}),t(e(v),null,{default:n(()=>[t(e(w),{class:"flex items-center gap-2 font-bold text-lg hover:text-primary transition-colors w-full"},{default:n(()=>[t(e(y),{class:"h-5 w-5"}),l[286]||(l[286]=o("span",null,"linkColumn",-1)),t(e(r),{variant:"secondary",class:"ml-2"},{default:n(()=>[...l[285]||(l[285]=[u("Link",-1)])]),_:1})]),_:1}),t(e(C),{class:"mt-3 space-y-4"},{default:n(()=>[l[304]||(l[304]=o("p",{class:"text-sm text-muted-foreground"}," Display clickable links with optional external link icon. Auto-truncates long URLs for better display. ",-1)),l[305]||(l[305]=o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"Usage Example"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`import { linkColumn } from '@/common/components/dashboards/datatable/columnDef';

// Basic usage (uses value as href)
linkColumn('website', 'Website')

// With custom href
linkColumn('website', 'Website', {
    href: (value, row) => \`https://\${value}\`,
    openInNewTab: true,
    showIcon: true
})

// External link
linkColumn('documentation_url', 'Docs', {
    openInNewTab: true,
    showIcon: true,
    className: 'font-medium'
})`)])],-1)),o("div",null,[l[303]||(l[303]=o("h4",{class:"font-semibold mb-2 text-sm"},"Properties",-1)),t(e(i),null,{default:n(()=>[t(e(f),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(d),null,{default:n(()=>[...l[287]||(l[287]=[u("Property",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[288]||(l[288]=[u("Type",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[289]||(l[289]=[u("Default",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[290]||(l[290]=[u("Description",-1)])]),_:1})]),_:1})]),_:1}),t(e(m),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[291]||(l[291]=[u("href",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[292]||(l[292]=[u("(value, row) => string",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[293]||(l[293]=[o("code",null,"value",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[294]||(l[294]=[u("Custom href function (defaults to cell value)",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[295]||(l[295]=[u("openInNewTab",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[296]||(l[296]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[297]||(l[297]=[o("code",null,"false",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[298]||(l[298]=[u('Open link in new tab (adds target="_blank")',-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[299]||(l[299]=[u("showIcon",-1)])]),_:1}),t(e(s),null,{default:n(()=>[t(e(r),{variant:"outline"},{default:n(()=>[...l[300]||(l[300]=[u("boolean",-1)])]),_:1})]),_:1}),t(e(s),null,{default:n(()=>[...l[301]||(l[301]=[o("code",null,"false",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[302]||(l[302]=[u("Show external link icon (only when openInNewTab is true)",-1)])]),_:1})]),_:1})]),_:1})]),_:1})]),l[306]||(l[306]=o("div",{class:"border-l-4 border-blue-500 pl-4 bg-blue-500/5 p-3 rounded"},[o("h5",{class:"font-semibold text-sm mb-2"},"💡 Note"),o("p",{class:"text-xs text-muted-foreground"}," URLs longer than 40 characters are automatically truncated for display. The full URL is still used in the href attribute. ")],-1))]),_:1})]),_:1})]),_:1})]),_:1}),t(e(p),null,{default:n(()=>[t(e(b),null,{default:n(()=>[t(e(g),null,{default:n(()=>[...l[308]||(l[308]=[u("🔧 Backend Integration (Laravel)",-1)])]),_:1})]),_:1}),t(e(x),{class:"space-y-4"},{default:n(()=>[l[331]||(l[331]=o("div",{class:"border-l-4 border-primary pl-4"},[o("h4",{class:"font-semibold mb-2"},"HasDataTable Trait"),o("p",{class:"text-sm text-muted-foreground"},[u(" The "),o("code",null,"HasDataTable"),u(" trait in BaseController provides the "),o("code",null,"dataTable()"),u(" method for server-side processing. ")])],-1)),l[332]||(l[332]=o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"1. Service Layer Configuration"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`<?php

namespace App\\Services\\Core;

use App\\Models\\User;
use Illuminate\\Database\\Eloquent\\Builder;

class UserService
{
    public function getBaseQuery(): Builder
    {
        return User::select('id', 'name', 'email', 'is_active', 'created_at')
            ->with('roles'); // Eager load relationships
    }

    public function getDataTableConfig(): array
    {
        return [
            'searchColumns' => ['name', 'email'],
            'allowedSorts' => ['name', 'email', 'created_at'],
            'allowedFilters' => [
                'role' => [
                    'type' => 'relationship',
                    'relationship' => 'roles',
                    'relation_column' => 'id',
                ],
                'status' => function ($query, $value) {
                    $query->where('is_active', $value === 'active' ? 1 : 0);
                },
                'created_from' => function ($query, $value) {
                    $query->whereDate('created_at', '>=', $value);
                },
                'created_to' => function ($query, $value) {
                    $query->whereDate('created_at', '<=', $value);
                },
            ],
        ];
    }
}`)])],-1)),l[333]||(l[333]=o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"2. Controller Implementation"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`<?php

namespace App\\Http\\Controllers\\SuperAdmin;

use App\\Http\\Controllers\\BaseController;
use App\\Services\\Core\\UserService;

class UsersController extends BaseController
{
    public function __construct(
        private UserService $userService
    ) {}

    public function index()
    {
        $query = $this->userService->getBaseQuery();
        $config = $this->userService->getDataTableConfig();

        $users = $this->dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        return Inertia::render(SuperAdminPath::view("users/Index"), [
            'users' => $users,
            'filters' => $this->getFilters(['role', 'status', 'created_from', 'created_to']),
        ]);
    }
}`)])],-1)),o("div",null,[l[330]||(l[330]=o("h4",{class:"font-semibold mb-2 text-sm"},"3. Filter Types",-1)),t(e(i),null,{default:n(()=>[t(e(f),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(d),null,{default:n(()=>[...l[309]||(l[309]=[u("Type",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[310]||(l[310]=[u("Example",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[311]||(l[311]=[u("Description",-1)])]),_:1})]),_:1})]),_:1}),t(e(m),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[312]||(l[312]=[u("equals",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[313]||(l[313]=[o("code",null,"['type' => 'equals', 'column' => 'status']",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[314]||(l[314]=[u("Exact match filter",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[315]||(l[315]=[u("like",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[316]||(l[316]=[o("code",null,"['type' => 'like', 'column' => 'name']",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[317]||(l[317]=[u("LIKE search filter",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[318]||(l[318]=[u("relationship",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[319]||(l[319]=[o("code",null,"['type' => 'relationship', 'relationship' => 'roles', 'relation_column' => 'id']",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[320]||(l[320]=[u("Filter by relationship",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[321]||(l[321]=[u("date_range",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[322]||(l[322]=[o("code",null,"['type' => 'date_range', 'column' => 'created_at']",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[323]||(l[323]=[u("Date range filter (expects array [from, to])",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[324]||(l[324]=[u("boolean",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[325]||(l[325]=[o("code",null,"['type' => 'boolean', 'column' => 'is_active']",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[326]||(l[326]=[u("Boolean filter",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-xs"},{default:n(()=>[...l[327]||(l[327]=[u("closure",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[328]||(l[328]=[o("code",null,"function($query, $value) { ... }",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[329]||(l[329]=[u("Custom filter logic",-1)])]),_:1})]),_:1})]),_:1})]),_:1})])]),_:1})]),_:1}),t(e(p),null,{default:n(()=>[t(e(b),null,{default:n(()=>[t(e(g),null,{default:n(()=>[...l[334]||(l[334]=[u("📡 Events",-1)])]),_:1})]),_:1}),t(e(x),null,{default:n(()=>[t(e(i),null,{default:n(()=>[t(e(f),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(d),{class:"w-[200px]"},{default:n(()=>[...l[335]||(l[335]=[u("Event",-1)])]),_:1}),t(e(d),{class:"w-[200px]"},{default:n(()=>[...l[336]||(l[336]=[u("Payload",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[337]||(l[337]=[u("Description",-1)])]),_:1})]),_:1})]),_:1}),t(e(m),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[338]||(l[338]=[u("@row-click",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[339]||(l[339]=[o("code",null,"row: TData",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[340]||(l[340]=[u("Emitted when a row is clicked",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[341]||(l[341]=[u("@selection-change",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[342]||(l[342]=[o("code",null,"rows: TData[]",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[343]||(l[343]=[u("Emitted when row selection changes",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[344]||(l[344]=[u("@update:filters",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[345]||(l[345]=[o("code",null,"filters: any",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[346]||(l[346]=[u("Emitted when filters change (server-side only)",-1)])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),t(e(p),null,{default:n(()=>[t(e(b),null,{default:n(()=>[t(e(g),null,{default:n(()=>[...l[347]||(l[347]=[u("🎨 Slots",-1)])]),_:1})]),_:1}),t(e(x),null,{default:n(()=>[t(e(i),null,{default:n(()=>[t(e(f),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(d),{class:"w-[200px]"},{default:n(()=>[...l[348]||(l[348]=[u("Slot",-1)])]),_:1}),t(e(d),{class:"w-[200px]"},{default:n(()=>[...l[349]||(l[349]=[u("Bindings",-1)])]),_:1}),t(e(d),null,{default:n(()=>[...l[350]||(l[350]=[u("Description",-1)])]),_:1})]),_:1})]),_:1}),t(e(m),null,{default:n(()=>[t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[351]||(l[351]=[u("#toolbar",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[352]||(l[352]=[o("code",null,"{ table }",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[353]||(l[353]=[u("Custom toolbar content (e.g., bulk action buttons)",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[354]||(l[354]=[u("#filters",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[355]||(l[355]=[o("code",null,"{ table }",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[356]||(l[356]=[u("Custom filter panel content",-1)])]),_:1})]),_:1}),t(e(a),null,{default:n(()=>[t(e(s),{class:"font-mono text-sm"},{default:n(()=>[...l[357]||(l[357]=[u("#empty",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[358]||(l[358]=[u("-",-1)])]),_:1}),t(e(s),null,{default:n(()=>[...l[359]||(l[359]=[u("Custom empty state when no data",-1)])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),t(e(p),null,{default:n(()=>[t(e(b),null,{default:n(()=>[t(e(g),null,{default:n(()=>[...l[360]||(l[360]=[u("🎯 Complete Example",-1)])]),_:1}),t(e(D),null,{default:n(()=>[...l[361]||(l[361]=[u(" Full implementation showing all features ",-1)])]),_:1})]),_:1}),t(e(x),{class:"space-y-4"},{default:n(()=>[...l[362]||(l[362]=[o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"Column Definitions (userColumns.ts)"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`import {
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
export function createUserColumns(openDeleteDialog: (user: User) => void) {
    const { showCopyToClipboardToast } = useToast();

    return createColumns<User>([
        counterColumn('#', { startFrom: 1 }),

        imageColumn('avatar_url', 'Avatar', {
            size: 'md',
            shape: 'circle',
            alt: (user) => user.name,
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
            onToggle: (value, user, control) => {
                router.patch(route('super-admin.users.toggle-status', user.id),
                    { is_active: value },
                    {
                        onSuccess: (page) => {
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
                onClick: (user) => {
                    navigator.clipboard.writeText(user.id);
                    showCopyToClipboardToast('User ID');
                },
            },
            { separator: true, label: 'Separator' },
            {
                label: 'View',
                icon: Eye,
                href: (user) => route('super-admin.users.show', user.id),
            },
            {
                label: 'Edit',
                icon: Edit,
                href: (user) => route('super-admin.users.edit', user.id),
            },
            { separator: true, label: 'Separator' },
            {
                label: 'Delete',
                icon: Trash2,
                destructive: true,
                onClick: (user) => openDeleteDialog(user),
            },
        ]),
    ]);
}`)])],-1),o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"Type Definition (type.ts)"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
    roles: Array<{ name: string; id: number }>;
    is_active?: boolean;
}`)])],-1),o("div",null,[o("h4",{class:"font-semibold mb-2 text-sm"},"Page Component (Index.vue)"),o("pre",{class:"bg-muted p-3 rounded text-sm overflow-x-auto"},[o("code",null,`<script setup lang="ts">
import DataTable from '@/common/components/dashboards/datatable/Datatable.vue';
import { createUserColumns } from './datatable/userColumns';
import type { User } from './datatable/type';
import { useFilters } from '@/core/composables/useFilters';
import { useDeleteDialog } from '@/modules/admin/composables/useDeleteDialog';

const props = defineProps<{
    users: {
        data: User[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    filters: any;
}>();

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
const { deleteDialogOpen, itemToDelete, openDeleteDialog } = useDeleteDialog<User>();

// Create columns with delete dialog function passed as parameter
const userColumns = createUserColumns(openDeleteDialog);

const handleRowClick = (user: User) => {
    router.get(route('super-admin.users.show', user));
};
<\/script>

<template>
    <DataTable
        :columns="userColumns"
        :data="users.data"
        :config="tableConfig"
        @row-click="handleRowClick"
    >
        <template #toolbar="{ table }">
            <Button
                v-if="table.getFilteredSelectedRowModel().rows.length > 0"
                variant="destructive"
                size="sm"
            >
                Delete ({ { table.getFilteredSelectedRowModel().rows.length } })
            </Button>
        </template>

        <template #filters>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <DashboardSelect
                    v-model="localFilters.role"
                    :options="roles"
                    optionLabel="name"
                    optionValue="id"
                    placeholder="All Roles"
                />
                <DashboardDatePicker
                    v-model="localFilters.created_from"
                    placeholder="From Date"
                />
                <DashboardDatePicker
                    v-model="localFilters.created_to"
                    placeholder="To Date"
                />
            </div>

            <div class="flex gap-2 mt-4">
                <Button @click="applyFilters">Apply Filters</Button>
                <Button @click="clearFilters" variant="outline">Clear</Button>
            </div>
        </template>
    </DataTable>
</template>`)])],-1)])]),_:1})]),_:1}),t(e(p),null,{default:n(()=>[t(e(b),null,{default:n(()=>[t(e(g),null,{default:n(()=>[...l[363]||(l[363]=[u("🆕 Recent Improvements & Pattern Changes",-1)])]),_:1})]),_:1}),t(e(x),null,{default:n(()=>[...l[364]||(l[364]=[o("div",{class:"space-y-4"},[o("div",{class:"border-l-4 border-green-500 pl-4 bg-green-500/5 p-3 rounded"},[o("h4",{class:"font-semibold mb-2 text-sm"},"✨ New Column Types"),o("ul",{class:"space-y-1 text-sm text-muted-foreground"},[o("li",null,[u("• "),o("code",null,"imageColumn()"),u(" - Display images with fallback, customizable size & shape")]),o("li",null,[u("• "),o("code",null,"linkColumn()"),u(" - Clickable links with auto-truncation and external link icons")]),o("li",null,[u("• "),o("code",null,"customColumn()"),u(" - Custom render functions for advanced use cases")])])]),o("div",{class:"border-l-4 border-blue-500 pl-4 bg-blue-500/5 p-3 rounded"},[o("h4",{class:"font-semibold mb-2 text-sm"},"🔧 Badge Column Enhancement"),o("p",{class:"text-sm text-muted-foreground mb-2"},[o("code",null,"badgeColumn"),u(" now supports multiple badges from arrays (e.g., user roles): ")]),o("pre",{class:"bg-muted p-2 rounded text-xs"},[o("code",null,`badgeColumn('roles', 'Roles', {
    multiple: true, // Automatically handles arrays
    variants: {
        'super-admin': 'destructive',
        'admin': 'default',
        'user': 'secondary'
    }
})`)])]),o("div",{class:"border-l-4 border-purple-500 pl-4 bg-purple-500/5 p-3 rounded"},[o("h4",{class:"font-semibold mb-2 text-sm"},"⚡ Factory Function Pattern (Breaking Change)"),o("p",{class:"text-sm text-muted-foreground mb-2"},[u(" Column definitions must now be "),o("strong",null,"factory functions"),u(" that accept dependencies as parameters: ")]),o("div",{class:"bg-muted p-2 rounded text-xs space-y-2"},[o("div",null,[o("div",{class:"text-red-500 font-semibold mb-1"},"❌ Old Pattern (Don't use):"),o("pre",null,[o("code",null,`// ❌ Module-level export with inject
export const userColumns = createColumns([...]);
const { openDeleteDialog } = useDeleteDialogTrigger();`)])]),o("div",null,[o("div",{class:"text-green-500 font-semibold mb-1"},"✅ New Pattern (Use this):"),o("pre",null,[o("code",null,`// ✅ Factory function with parameters
export function createUserColumns(openDeleteDialog: (user: User) => void) {
    return createColumns([...]);
}`)])])]),o("p",{class:"text-xs text-muted-foreground mt-2"},[o("strong",null,"Why?"),u(" Prevents timing issues with Vue's provide/inject in <script setup> and makes dependencies explicit. ")])]),o("div",{class:"border-l-4 border-orange-500 pl-4 bg-orange-500/5 p-3 rounded"},[o("h4",{class:"font-semibold mb-2 text-sm"},"🎯 Simplified Delete Dialog Pattern"),o("p",{class:"text-sm text-muted-foreground mb-2"}," No more global window hacks or provide/inject complexity: "),o("pre",{class:"bg-muted p-2 rounded text-xs"},[o("code",null,`// In Index.vue
const { deleteDialogOpen, itemToDelete, openDeleteDialog } = useDeleteDialog<User>();
const userColumns = createUserColumns(openDeleteDialog); // Pass it directly!

// In column definition
onClick: (user) => openDeleteDialog(user) // Clean & type-safe!`)])])],-1)])]),_:1})]),_:1}),t(e(p),null,{default:n(()=>[t(e(b),null,{default:n(()=>[t(e(g),null,{default:n(()=>[...l[365]||(l[365]=[u("✅ Best Practices",-1)])]),_:1})]),_:1}),t(e(x),null,{default:n(()=>[...l[366]||(l[366]=[o("div",{class:"space-y-4"},[o("div",{class:"border-l-4 border-green-500 pl-4"},[o("h4",{class:"font-semibold mb-2 text-sm"},"Performance"),o("ul",{class:"space-y-1 text-sm text-muted-foreground"},[o("li",null,[u("• Use "),o("code",null,"select()"),u(" in base queries to only load needed columns")]),o("li",null,[u("• Eager load relationships with "),o("code",null,"with()"),u(" to prevent N+1 queries")]),o("li",null,"• Enable server-side pagination for large datasets (>1000 rows)"),o("li",null,"• Use debouncing for search (300ms default)")])]),o("div",{class:"border-l-4 border-blue-500 pl-4"},[o("h4",{class:"font-semibold mb-2 text-sm"},"Organization"),o("ul",{class:"space-y-1 text-sm text-muted-foreground"},[o("li",null,[u("• Keep column definitions in separate "),o("code",null,"datatable/"),u(" folder")]),o("li",null,"• Define TypeScript interfaces for row data"),o("li",null,"• Use service layer for DataTable configuration"),o("li",null,"• Extract reusable filters into composables"),o("li",null,[u("• ⚠️ "),o("strong",null,"Use factory functions"),u(" for column definitions (export function, not const)")]),o("li",null,[u("• ⚠️ "),o("strong",null,"Pass functions as parameters"),u(" instead of using provide/inject in column files")])])]),o("div",{class:"border-l-4 border-yellow-500 pl-4"},[o("h4",{class:"font-semibold mb-2 text-sm"},"Security"),o("ul",{class:"space-y-1 text-sm text-muted-foreground"},[o("li",null,[u("• Whitelist sortable columns in "),o("code",null,"allowedSorts")]),o("li",null,[u("• Whitelist searchable columns in "),o("code",null,"searchColumns")]),o("li",null,"• Validate filter values on backend"),o("li",null,"• Use middleware for permission checks on actions")])]),o("div",{class:"border-l-4 border-purple-500 pl-4"},[o("h4",{class:"font-semibold mb-2 text-sm"},"UX"),o("ul",{class:"space-y-1 text-sm text-muted-foreground"},[o("li",null,"• Provide meaningful search placeholders"),o("li",null,"• Show loading states during toggle actions"),o("li",null,[u("• Use "),o("code",null,"preserveScroll: true"),u(" for better UX")]),o("li",null,"• Display empty states when no results"),o("li",null,"• Use relative dates for recent timestamps")])])],-1)])]),_:1})]),_:1})]))}});export{R as _};
