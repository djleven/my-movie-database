// Globally register all base components
// https://webpack.js.org/guides/dependency-management/#require-context
const requireComponent = require.context(
    // Look for files in the current directory
    './components',
    // Do not look in subdirectories
    true,
    // Only include "_base-" prefixed .vue files
    /\.vue$/
)

const registerAllComponents = (app) => {
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
        app.component(componentName, componentConfig.default || componentConfig)
    })

}

export default registerAllComponents
