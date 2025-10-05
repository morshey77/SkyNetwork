<?php


namespace Morcheysha77\Faction\Constants\Socket;


interface ServerPacketID
{

    public const
        SEND_BROADCAST_MESSAGE_NETWORK = 0x0,
        SEND_BROADCAST_POPUP_NETWORK = 0x1,
        SEND_BROADCAST_TIP_NETWORK = 0x2,
        SEND_BROADCAST_TITLE_NETWORK = 0x3;

}