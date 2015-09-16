module.exports = {
    entry: "./web/survey-builder/app/survey-builder-app.js",
    output: {
        path: "./web/survey-builder",
        publicPath: "/web/survey-builder/",
        filename: "build.js"
    },
    module: {
        loaders: [
            {test: /\.html$/, loader: "html"}
        ]
    }
}
