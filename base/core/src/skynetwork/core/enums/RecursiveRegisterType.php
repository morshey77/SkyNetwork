<?php

namespace skynetwork\core\enums;

enum RecursiveRegisterType {

    case BLOCK;
    case COMMAND;
    case LISTENER;
    case ITEM;
    case MANAGER;
    case REPEATING_TASK;

}