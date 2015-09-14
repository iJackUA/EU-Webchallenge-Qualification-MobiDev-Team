module.exports = {
    entry: "./web/survey-builder-gui/app/survey-builder-app.js",
    output: {
        path: "./web/survey-builder-gui",
        publicPath: "/web/survey-builder-gui/",
        filename: "build.js"
    },
    module: {
        loaders: [
            {test: /\.html$/, loader: "html"}
        ]
    }
}
