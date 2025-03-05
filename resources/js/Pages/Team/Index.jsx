import React from 'react';
import CustomHeader from '@/Layouts/CustomHeader';
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
  } from "../../../../src/components/ui/menu";
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
  } from "../../../../src/components/ui/dialog"
import { Field } from '../../../../src/components/ui/field';


const Teams = ({ teams }) => {
    return (
        <ChakraProvider value={defaultSystem}>
        <>
            <CustomHeader />
            {/* <HStack width="100%" justifyContent="space-between" alignItems="center" padding="0 20px"> */}
                {/* ロゴ */}
                {/* <Image width={'150px'} src="img/logo.png" /> */}

                {/* メニュー */}
                {/* <Box className='menu'>
                    <HStack direction={{ base: "column", md: "row" }} gap="10" separator={<StackSeparator />}>
                        <Link>チーム</Link>
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
                </Box> */}

                {/* ユーザーメニュー */}
                {/* <Box className='user_menu' marginRight='20px'>
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
            </HStack> */}

            {/* メイン */}
                <Box className='main' width="90%" m="auto" bg='white' marginTop='20px' boxShadow='md' >
                    <HStack bg='gray.400' color='white'>
                        <Text textStyle={'2xl'} m='20px'>チーム一覧</Text>

                        {/* <Spacer /> */}
                        <DialogRoot>
                            <DialogTrigger asChild>
                                <Button variant="outline" size="xxl" bg="gray.800" p='0.5rem'>
                                検索
                                </Button>
                            </DialogTrigger>
                                <DialogContent>
                                    <DialogHeader>
                                        <Center>
                                            <DialogTitle>チーム検索</DialogTitle>
                                        </Center>
                                    </DialogHeader>
                                    <DialogBody>
                                        <form>
                                            <Stack gap="4">
                                                <Field label="チーム名">
                                                    <Input
                                                        placeholder='チーム名を入力してください'
                                                        type='text'
                                                        id='team_name'
                                                        name='team_name'
                                                        value={FormData.team_name}
                                                    />
                                                </Field>
                                                <Field label="種目">
                                                    <NativeSelectRoot>
                                                        <NativeSelectField placeholder='登録した種目マスタから選択してください'>
                                                            <option value="1">サッカー</option>
                                                            <option value="2">バスケ</option>
                                                        </NativeSelectField>
                                                    </NativeSelectRoot>
                                                </Field>
                                            </Stack>
                                            {/* <HStack marginY="1rem">
                                                <Text>チーム名</Text>
                                                <Input
                                                    placeholder='チーム名を入力'
                                                    size='lg'
                                                    type='text'
                                                    id='team_name'
                                                    name='team_name'
                                                    value={FormData.team_name}
                                                />
                                            </HStack>
                                            <HStack>
                                                <Text>種目</Text>
                                                <NativeSelectRoot>
                                                    <NativeSelectField placeholder='登録した種目マスタから選択してください'>
                                                        <option value="1">サッカー</option>
                                                        <option value="2">バスケ</option>
                                                    </NativeSelectField>
                                                </NativeSelectRoot>
                                            </HStack> */}
                                            {/* <Center>
                                                <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='40%'>登録</Button>
                                            </Center> */}
                                        </form>
                                    </DialogBody>
                                    <DialogFooter>
                                        {/* <DialogActionTrigger asChild>
                                            <Button variant="outline" color='white' bg='gray.500' size='lg' p='5' width='30%'>閉じる</Button>
                                        </DialogActionTrigger> */}
                                        <Button as={Link} href={`/teams`} color='white' bg='gray.500' size='lg' p='5' width='30%'>リセット</Button>
                                        <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='30%'>登録</Button>
                                    </DialogFooter>
                                <DialogCloseTrigger />
                            </DialogContent>
                        </DialogRoot>
                        <Button as={Link} href={`/teams/create`} bg='orange.400' p="1rem">
                            チームを登録する
                        </Button>
                    </HStack>

                    {/* 検索フォーム */}
                    {/* <Box width='40%' m='auto' marginY='2rem'>
                        <form>
                            <HStack>
                                <Text>チーム名</Text>
                                <Input
                                    placeholder='チーム名を入力'
                                    size='lg'
                                    type='text'
                                    id='team_name'
                                    name='team_name'
                                    value={FormData.team_name}
                                />
                            </HStack>
                            <HStack spaceX='2rem' align='center'>
                                <Button type='submit' color='white' bg='orange.500' size='lg' p='5'>検索</Button>
                                <Button bg='gray.500' color='white' size='lg' p='5' >リセット</Button>
                            </HStack>
                        </form>
                    </Box> */}

                    {/* テーブル */}
                    {/* <Box w="90%" m="auto" marginBottom="10px" h="58vh" border="1px solid" borderColor="gray.200" p="1rem"> */}
                    <Table.ScrollArea w="90%" m="auto" marginY="2rem" h="70vh" border="1px solid" borderColor="gray.200" p="1rem">
                    <Table.Root>
                        <Table.Header position="sticky" top="0" zIndex="1" bg='gray.400'>
                            <Table.Row>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' w='15%' fontSize={'md'}>チーム名</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' w='15%' fontSize={'md'}>種目</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' fontSize={'md'}>チーム詳細</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' fontSize={'md'}>所属選手一覧</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' fontSize={'md'}>傷病者一覧</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' fontSize={'md'}>分析一覧</Table.ColumnHeader>
                            </Table.Row>
                        </Table.Header>

                            <Table.Body>
                                {teams.map((team, index) => (
                                    <Table.Row key={index}>
                                        <Table.Cell textAlign='center'  borderBottom="1px solid" borderColor="gray.300">{team.team_name}</Table.Cell>
                                        <Table.Cell textAlign='center'  borderBottom="1px solid" borderColor="gray.300">サッカー</Table.Cell>
                                        <Table.Cell  borderBottom="1px solid" borderColor="gray.300">
                                            <Link variant='plain' href=''>
                                                <Center>
                                                    <Image src="img/team.png" />
                                                </Center>
                                            </Link>
                                        </Table.Cell>
                                        <Table.Cell  borderBottom="1px solid" borderColor="gray.300">
                                            <Link variant='plain' href=''>
                                                <Center>
                                                    <Image src="img/athlete.png" />
                                                </Center>
                                            </Link>
                                            {/* <Box colorInterpolation='gray'>
                                                <Button as={Link} href={``} bg='gray.300' color='white' size='lg'>
                                                    一覧
                                                </Button>
                                            </Box> */}
                                        </Table.Cell>
                                        <Table.Cell  borderBottom="1px solid" borderColor="gray.300">
                                            <Link variant='plain' href=''>
                                                <Center>
                                                    <Image src="img/injury_infomation.png" />
                                                </Center>
                                            </Link>
                                        </Table.Cell>
                                        <Table.Cell  borderBottom="1px solid" borderColor="gray.300">
                                            <Link variant='plain' href=''>
                                                <Center>
                                                    <Image src="img/analyze_data.png" />
                                                </Center>
                                            </Link>
                                        </Table.Cell>
                                    </Table.Row>
                                ))}
                            </Table.Body>

                    </Table.Root>
                    </Table.ScrollArea>
                    {/* </Box> */}

                </Box>

        </>
        </ChakraProvider>
    );
}

export default Teams;
