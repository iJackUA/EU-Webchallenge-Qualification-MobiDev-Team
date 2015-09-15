var UUID = require('uuid-js');

module.exports = {
    makeUUID: function () {
        return UUID.create(4).toString();
    }
};
