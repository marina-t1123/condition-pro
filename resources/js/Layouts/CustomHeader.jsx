import { memo, useState } from 'react';

import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import {
    Text,
    Box,
    Image,
    HStack,
    StackSeparator,
    Button,
    Alert
} from '@chakra-ui/react';
import {
    MenuContent,
    MenuItem,
    MenuRoot,
    MenuTrigger,
} from "../../../src/components/ui/menu";


export const Header = () => {

    // InertiaのusePageを使用して、フラッシュメッセージを表示できるように設定
    const page = usePage();
    // console.log(page);
    // console.log(page.props.flash.message);

    return (
        <Box>
            <HStack width="100%" justifyContent="space-between" alignItems="center" padding="0 20px">
                {/* ロゴ */}
                <Image width={'150px'} src="/img/logo.png" />

                {/* メニュー */}
                <Box className='menu'>
                    <HStack direction={{ base: "column", md: "row" }} gap="10" separator={<StackSeparator />}>
                        <Text as={Link} href={`/teams`}>チーム</Text>
                        <Text as={Link} href={`/athletes`}>選手</Text>
                        <Link>傷病情報</Link>
                        <Link>グラフ</Link>
                        <MenuRoot>
                            <MenuTrigger asChild>
                                <Button size='sm' variant="outline">
                                    マスタ
                                </Button>
                            </MenuTrigger>
                            <MenuContent>
                                <MenuItem asChild value="m_event">
                                    <a
                                        href="/m_events"
                                        target="_blank"
                                        rel="noreferrer"
                                    >
                                        種目
                                    </a>
                                </MenuItem>
                                <MenuItem asChild value="m_event_position">
                                    <a
                                        href="/m_event_positions"
                                        target="_blank"
                                        rel="noreferrer"
                                    >
                                        ポジション・階級
                                    </a>
                                </MenuItem>
                                <MenuItem asChild value="m_body_part">
                                    <a
                                        href="/m_body_parts"
                                        target="_blank"
                                        rel="noreferrer"
                                    >
                                        部位
                                    </a>
                                </MenuItem>
                                <MenuItem asChild value="m_injury_name">
                                    <a
                                        href=""
                                        target="_blank"
                                        rel="noreferrer"
                                    >
                                        傷病名
                                    </a>
                                </MenuItem>
                            </MenuContent>
                        </MenuRoot>
                    </HStack>
                </Box>

                {/* ユーザーメニュー */}
                <Box className='user_menu' marginRight='20px'>
                    <MenuRoot>
                        <MenuTrigger asChild>
                            <Button size='sm' variant="outline">
                                ユーザーネーム
                            </Button>
                        </MenuTrigger>
                        <MenuContent>
                            <MenuItem asChild>
                                <a
                                    href=""
                                    target="_blank"
                                    rel="noreferrer"
                                >
                                    ユーザー情報
                                </a>
                            </MenuItem>
                            <MenuItem asChild>
                                <a
                                    href=""
                                    target="_blank"
                                    rel="noreferrer"
                                >
                                    ログアウト
                                </a>
                            </MenuItem>
                        </MenuContent>
                    </MenuRoot>
                </Box>
            </HStack>
            {/* フラッシュメッセージ表示 */ }
            {
                page.props.flash.message && (<Alert.Root status="info" title="This is the alert title">
                    <Alert.Indicator />
                    <Alert.Title>{page.props.flash.message}</Alert.Title>
                </Alert.Root>)
            }
        </Box>
    )
}

export default Header;
