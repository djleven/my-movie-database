Vue.component("tv-seasons", {
    template: `
    <sections :header="$store.state.__t.seasons"
              :sub-header="$store.state.content.name"
              class-list="seasons">
              <credits :title="$store.state.__t.seasons"
                     :overview-on-hover="mmdb_conf.overviewOnHover"
                     image-size="medium"
                     column-class="twoColumn"
                     :credits="$store.state.content.seasons">
              </credits>
    </sections>`
});