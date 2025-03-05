import { memo, useState } from 'react';

import React from 'react';
import { Link } from '@inertiajs/react';
import {
    ChakraProvider,
    defaultSystem,
    Text,
    Box,
    Table,
    Image,
    HStack,
    StackSeparator,
    Button,
    Center,
    Input,
    NativeSelectRoot,
    NativeSelectField,
    VStack,
    Stack
} from '@chakra-ui/react';
import {
    MenuContent,
    MenuItem,
    MenuRoot,
    MenuTrigger,
  } from "../../../src/components/ui/menu";
import {
    DialogActionTrigger,
    DialogBody,
    DialogCloseTrigger,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogRoot,
    DialogTitle,
    DialogTrigger,
  } from "../../../src/components/ui/dialog"
import { Field } from '../../../src/components/ui/field';

export const Header = () => {
    return (
        <HStack width="100%" justifyContent="space-between" alignItems="center" padding="0 20px">
            {/* ロゴ */}
            <Image width={'150px'} src="img/logo.png" />

            {/* メニュー */}
            <Box className='menu'>
                <HStack direction={{ base: "column", md: "row" }} gap="10" separator={<StackSeparator />}>
                    <Text as={Link} href={`/teams`}>チーム</Text>
                    <Link>選手</Link>
                    <Link>傷病情報</Link>
                    <Link>グラフ</Link>
                    <MenuRoot>
                        <MenuTrigger asChild>
                            <Button size='sm' variant="outline">
                                マスタメニュー
                            </Button>
                        </MenuTrigger>
                        <MenuContent>
                            <MenuItem asChild>
                                <a
                                　href=""
                                　target="_blank"
                                　rel="noreferrer"
                                >
                                    種目
                                </a>
                            </MenuItem>
                            <MenuItem asChild>
                                <a
                                　href=""
                                　target="_blank"
                                　rel="noreferrer"
                                >
                                    カテゴリー
                                </a>
                            </MenuItem>
                            <MenuItem asChild>
                                <a
                                　href=""
                                　target="_blank"
                                　rel="noreferrer"
                                >
                                    部位
                                </a>
                            </MenuItem>
                            <MenuItem asChild>
                                <a
                                　href=""
                                　target="_blank"
                                　rel="noreferrer"
                                >
                                    傷病名
                                </a>
                            </MenuItem>
                            <MenuItem asChild>
                                <a
                                　href=""
                                　target="_blank"
                                　rel="noreferrer"
                                >
                                    シュチュエーション
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
    )
}

export default Header;
