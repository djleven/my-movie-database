<template>
    <sections :header="$store.state.__t.seasons"
              :sub-header="$store.state.content.name"
              class-list="seasons">
        <credits :title="$store.state.__t.seasons"
                 :overview-on-hover="$store.state.global_conf.overviewOnHover"
                 image-size="medium"
                 column-class="twoColumn"
                 :credits="$store.state.content.seasons">
        </credits>
    </sections>
</template>
