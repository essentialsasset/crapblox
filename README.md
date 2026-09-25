# Crapblox

## DO NOT USE IN PRODUCTION !!!

This code is a horrible mismash and a horrile weird combination of code from years ago, and this is not even using a proper MVC framework.

Do not build on top of this code.

## Environment Options

### MMMMOH_ENABLE

    MMMMOH_ENABLE=(any value)
    If MMMMOH_ENABLE is defined, then the insecure stock/event item giving API's are enabled. The Key will be the value of MMMMOH_ENABLE.

### CRAPBLOX

    CRAPBLOX=[development, release]
    If CRAPBLOX is set to development, the site enters development mode. Otherwise, if it is set to release, the site enters release mode.
    Any value other then development or release is undefined behaviour.

### SYSTEM_MESSAGE

    SYSTEM_MESSAGE="...string..."
    If SYSTEM_MESSAGE is defined, then the Crapblox system message will be set to its value. SYSTEM_MESSAGE requires SYSTEM_MESSAGE_TYPE to be defined.

### SYSTEM_MESSAGE_TYPE

    SYSTEM_MESSAGE_TYPE=[TypeError, TypeSuccess]
    SYSTEM_MESSAGE requires this to be defined. This sets the styling of the system message to SYSTEM_MESSAGE_TYPE. Other values should be added as it uses the SYSTEM_MESSAGE_TYPE in the div's class

### STOCKS

    STOCKS=[ON, OFF]
    If STOCKS=OFF, then buying/selling stocks will be disabled, and the /Stocks/Group/{GroupID} view will be disabled.
