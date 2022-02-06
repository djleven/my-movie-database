// Globally register all base components
// Components are registered using the PascalCased version of their file name.

import Vue from 'vue'

// https://webpack.js.org/guides/dependency-management/#require-context
const requireComponent = require.context(
    // Look for files in the current directory
    '.',
    // Do not look in subdirectories
    true,
    // Only include "_base-" prefixed .vue files
    /\.vue$/
)

// For each matching file name...
requireComponent.keys().forEach((fileName) => {
    // Get the component config
    const componentConfig = requireComponent(fileName)
    // Get the PascalCase version of the component name
    const componentName = (fileName.split('\\').pop().split('/').pop().split('.'))[0]
        // Split up kebabs
        .split('-')
        // Upper case
        .map((kebab) => kebab.charAt(0).toUpperCase() + kebab.slice(1))
        // Concatenated
        .join('')
    // Globally register the component
    Vue.component(componentName, componentConfig.default || componentConfig)
})